<?php

class CreqDataShell
{
    const CREQ_MODULE_COURSE = 1;
    const CREQ_MODULE_OUTCOME = 2;
    const CREQ_MODULE_PLAN = 3;

    protected $creqModuleUrls = array(
        self::CREQ_MODULE_COURSE => 'https://creq.unl.edu/courses/public-view/',
        self::CREQ_MODULE_OUTCOME => 'https://creq.unl.edu/learningoutcomes/view/feed/',
        self::CREQ_MODULE_PLAN => 'https://creq.unl.edu/fouryearplans/view/feed/',
    );

    protected $activeEdition;

    protected $shellCol = 60;

    /**
     * @return UNL_UndergraduateBulletin_CourseDataDriver
     */
    protected function getCourseService()
    {
        $courseService = UNL_Services_CourseApproval::getXCRIService();

        if (!$courseService instanceof UNL_UndergraduateBulletin_CourseDataDriver) {
            $courseService = new UNL_UndergraduateBulletin_CourseDataDriver();
            UNL_Services_CourseApproval::setXCRIService($courseService);
        }

        return $courseService;
    }

    /**
     * @return UNL_UndergraduateBulletin_Edition
     */
    protected function getEdition()
    {
        if (!$this->activeEdition) {
            if (isset($_SERVER['argv'], $_SERVER['argv'][1])) {
                $this->activeEdition = UNL_UndergraduateBulletin_Edition::getByYear($_SERVER['argv'][1]);
            } else {
                $this->activeEdition = UNL_UndergraduateBulletin_Editions::getLatest();
            }
        }

        return $this->activeEdition;
    }

    /**
     * @return UNL_UndergraduateBulletin_Edition[]
     */
    protected function getEditions()
    {
        if (isset($_SERVER['argv'], $_SERVER['argv'][1])) {
            $editions = array(UNL_UndergraduateBulletin_Edition::getByYear($_SERVER['argv'][1]));
        } else {
            $editions = UNL_UndergraduateBulletin_Editions::getAll();
        }

        return $editions;
    }

    /**
     * @param string $src Source URL relative to Creq public base URL
     * @param string $dest Destination file path relative to edition course data
     * @param bool $removeOnFail If the destination file should be removed if request fails
     * @return mixed Returns a boolean result if a destination is given, otherwise the content is returned
     */
    protected function fetchCreqFile($module, $src, $dest, $removeOnFail = false)
    {
        if (!isset($this->creqModuleUrls[$module])) {
            throw new InvalidArgumentException('That creq module does not exist');
        }

        $curlHandle = curl_init($this->creqModuleUrls[$module] . $src);
        curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);

        if (null !== $dest) {
            $file = $this->getEdition()->getCourseDataDir() . '/' . $dest;
            $filePointer = fopen($file, 'w+');
            curl_setopt($curlHandle, CURLOPT_FILE, $filePointer);
        } else {
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        }


        $result = curl_exec($curlHandle);
        curl_close($curlHandle);

        if (null !== $dest) {
            fclose($filePointer);

            if ($result === false && $removeOnFail) {
                @unlink($file);
            }
        }

        return $result;
    }

    protected function echoSuccess()
    {
        $result = ' DONE ';

        echo "\033[{$this->shellCol}G";
        echo '[';
        echo "\033[1;32m";
        echo $result;
        echo "\033[0;39m";
        echo ']' . PHP_EOL;
    }

    protected function echoFailure()
    {
        $result = 'FAILED';

        echo "\033[{$this->shellCol}G";
        echo '[';
        echo "\033[1;31m";
        echo $result;
        echo "\033[0;39m";
        echo ']' . PHP_EOL;
    }

    public function fetchUpdates()
    {
        $edition = $this->getEdition();
        $this->getCourseService()->setEdition($edition);

        echo '[Updating course data for ' . $edition->getYear() . ']' . PHP_EOL;

        try {
            echo 'Updating all course data file';

            $this->fetchCreqFile(self::CREQ_MODULE_COURSE, 'all-courses', 'all-courses.xml');

            $this->echoSuccess();
        } catch (Exception $e) {
            $this->echoFailure();
            exit(1);
        }

        try {
            echo 'Retrieving all courses by subject code';

            foreach (array_keys(UNL_UndergraduateBulletin_SubjectAreas::getMap($edition)) as $subject) {
                if (!$this->fetchCreqFile(self::CREQ_MODULE_COURSE, 'all-courses/subject/' . $subject, 'subjects/' . $subject . '.xml', true)) {
                    throw new UnexpectedValueException($subject);
                }
            }

            $this->echoSuccess();
        } catch (UnexpectedValueException $e) {
            echo ' (' . $e->getMessage() . ')';
            $this->echoFailure();
            exit(1);
        } catch (Exception $e) {
            $this->echoFailure();
            exit(1);
        }

        $this->rebuildData();
    }

    public function rebuildData()
    {
        $edition = $this->getEdition();
        $this->getCourseService()->setEdition($edition);

        echo '[Rebuilding internal course data for ' . $edition->getYear() . ']' . PHP_EOL;

        try {
            echo 'Creating minimized course data file for JSON output';
            $this->minimizeCourseData($edition->getCourseDataDir());
            $this->echoSuccess();
        } catch (Exception $e) {
            $this->echoFailure();
            exit(1);
        }

        echo PHP_EOL;
        $this->buildDb();
    }

    protected function minimizeCourseData($dataDir)
    {
        $xml = $this->getCourseService()->getAllCourses();
        $courses = new SimpleXMLElement($xml);
        foreach ($courses as $course) {
            foreach (array(
                'prerequisite',
                'description',
                'effectiveSemester',
                'gradingType',
                'dfRemoval',
                'campuses',
                'deliveryMethods',
                'termsOffered',
                'activities',
                'credits',
                'notes',
            ) as $var) {
                unset($course->$var);
            }
        }

        $courses = str_replace("    \n", "", $courses->asXML());
        file_put_contents($dataDir . '/all-courses-min.xml', $courses);
    }

    public function buildDb()
    {
        echo '[Building course search databases]' . PHP_EOL;

        foreach ($this->getEditions() as $edition) {
            try {
                echo 'Building for edition ' . $edition->getYear();

                $dbFile = $edition->getCourseDataDir().'/courses.sqlite';
                @unlink($dbFile);
                $db = new PDO('sqlite:'. $dbFile);

                $db->exec('CREATE TABLE IF NOT EXISTS courses (
    id INT UNSIGNED NOT NULL ,
    subjectArea VARCHAR( 4 ) NOT NULL ,
    courseNumber VARCHAR( 4 ) NOT NULL ,
    title VARCHAR( 255 ) NOT NULL ,
    slo VARCHAR( 20 ) NOT NULL ,
    prerequisite TEXT NULL,
    credits INT UNSIGNED NULL ,
    xml MEDIUMTEXT NOT NULL ,
    PRIMARY KEY ( id )
);');

                $db->exec('CREATE INDEX IF NOT EXISTS IX_courses_subjectArea ON courses ( subjectArea );');
                $db->exec('CREATE INDEX IF NOT EXISTS IX_courses_courseNumber ON courses ( courseNumber );');
                $db->exec('CREATE INDEX IF NOT EXISTS IX_courses_credits ON courses ( credits );');
                $db->exec('CREATE INDEX IF NOT EXISTS IX_courses_prerequisite ON courses ( prerequisite );');

                $db->exec('ALTER TABLE `courses` ADD INDEX ( `subjectArea` )  ');
                $db->exec('ALTER TABLE `courses` ADD INDEX ( `courseNumber` )  ');
                $db->exec('ALTER TABLE `courses` ADD INDEX ( `credits` )  ');
                $db->exec('ALTER TABLE `courses` ADD INDEX ( `prerequisite` )  ');

                $db->exec('CREATE TABLE IF NOT EXISTS crosslistings (
    course_id INT UNSIGNED NOT NULL ,
    subjectArea VARCHAR( 4 ) NOT NULL ,
    courseNumber VARCHAR( 4 ) NOT NULL
);');

                $db->exec('CREATE INDEX IF NOT EXISTS IX_crosslistings_course_id ON crosslistings ( course_id );');
                $db->exec('CREATE INDEX IF NOT EXISTS IX_crosslistings_subjectArea ON crosslistings ( subjectArea );');
                $db->exec('CREATE INDEX IF NOT EXISTS IX_crosslistings_courseNumber ON crosslistings ( courseNumber );');
                $db->exec('ALTER TABLE `crosslistings` ADD INDEX ( `course_id` )  ');
                $db->exec('ALTER TABLE `crosslistings` ADD INDEX ( `subjectArea` )  ');
                $db->exec('ALTER TABLE `crosslistings` ADD INDEX ( `courseNumber` )  ');

                $db->exec('CREATE TABLE IF NOT EXISTS prereqs (
    course_id INT UNSIGNED NOT NULL ,
    subjectArea VARCHAR( 4 ) NOT NULL ,
    courseNumber VARCHAR( 4 ) NOT NULL
);');

                $db->exec('CREATE INDEX IF NOT EXISTS IX_prereqs_subjectArea_courseNumber ON prereqs ( subjectArea, courseNumber );');

                $course_stmt = $db->prepare('INSERT INTO courses (id,subjectArea,courseNumber,title,slo,prerequisite,credits,xml) VALUES (?,?,?,?,?,?,?,?);');
                $cross_stmt =  $db->prepare('INSERT INTO crosslistings (course_id, subjectArea, courseNumber) VALUES (?,?,?);');
                $prereq_stmt = $db->prepare('INSERT INTO prereqs (course_id, subjectArea, courseNumber) VALUES (?,?,?);');

                $id = 0;
                $this->getCourseService()->setEdition($edition);
                $xml = new SimpleXMLElement($this->getCourseService()->getAllCourses());
                $namespaces = $xml->getNamespaces(true);
                $xml->registerXPathNamespace('c', $namespaces['']);
                $courses = new UNL_Services_CourseApproval_Courses($xml->xpath('/c:courses/c:course'));
                unset($xml, $namespaces);

                foreach ($courses as $course) {
                    /**
                     * @var UNL_Services_CourseApproval_Course $course
                     */
                    $home = $course->getHomeListing();

                    $values = array();
                    $values[] = ++$id;
                    $values[] = (string)$home->subjectArea;
                    $values[] = $home->courseNumber;
                    //$values[] = $home->courseLetter;
                    $values[] = $course->title;
                    if (isset($course->aceOutcomes)) {
                        $values[] = implode(',', $course->aceOutcomes);
                    } else {
                        $values[] = '';
                    }

                    $values[] = $course->prerequisite;
                    $prereqs = UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($course->prerequisite);
                    foreach ($prereqs as $subj => $courseNums) {
                        foreach ($courseNums as $num) {
                            $prereq_stmt->execute(array($id, $subj, $num));
                        }
                    }
                    unset($subj, $courseNums, $num, $prereqs);


                    $credits = $course->getCredits();
                    if (isset($credits['Single Value'])) {
                        $values[] = $credits['Single Value'];
                    } else {
                        $values[] = null;
                    }

                    $values[] = $course->asXML();

                    $course_stmt->execute($values);

                    foreach ($course->codes as $listing) {
                        $values = array($id, $listing->subjectArea, $listing->courseNumber);
                        $cross_stmt->execute($values);
                    }
                }

                $this->echoSuccess();
            } catch (Exception $e) {
                $this->echoFailure();
                exit(1);
            }
        }
    }

    public function fetchOutcomes()
    {
        $edition = $this->getEdition();

        echo '[Updating outcomes for ' . $edition->getYear() . ']' . PHP_EOL;

        try {
            echo 'Retrieving feed';

            $outcomes = $this->fetchCreqFile(self::CREQ_MODULE_OUTCOME, '', null);
            if (!$outcomes) {
                throw new UnexpectedValueException('Outcomes did not properly load');
            }
            $outcomes = json_decode($outcomes);

            foreach ($outcomes as $outcome) {
                // Try and get the associated major
                $major = UNL_UndergraduateBulletin_Major::getByName($outcome->major);

                if (false === $major) {
                    throw new UnexpectedValueException('Could not find ' . $outcome->major);
                }

                $data = json_encode($outcome);
                $filename = UNL_UndergraduateBulletin_EPUB_Utilities::getFilenameBaseByName($outcome->major);

                file_put_contents($edition->getDataDir() . '/outcomes/' . $filename . '.json', $data);
            }

            $this->echoSuccess();
        } catch (Exception $e) {
            $this->echoFailure();
            exit(1);
        }
    }

    public function fetchPlans()
    {
        $edition = $this->getEdition();

        echo '[Updating 4-year plans for ' . $edition->getYear() . ']' . PHP_EOL;

        try {
            echo 'Retrieving feed';

            $plans = $this->fetchCreqFile(self::CREQ_MODULE_PLAN, '', null);
            if (!$plans) {
                throw new UnexpectedValueException('Outcomes did not properly load');
            }
            $plans = json_decode($plans);

            foreach ($plans as $plan) {
                // Try and get the associated major
                $major = UNL_UndergraduateBulletin_Major::getByName($plan->major);

                if (false === $major) {
                    throw new UnexpectedValueException('Could not find ' . $plan->major);
                }

                $data = json_encode($plan);
                $filename = UNL_UndergraduateBulletin_EPUB_Utilities::getFilenameBaseByName($plan->major);

                file_put_contents($edition->getDataDir() . '/fouryearplans/' . $filename . '.json', $data);
            }

            $this->echoSuccess();
        } catch (Exception $e) {
            $this->echoFailure();
            exit(1);
        }
    }
}
