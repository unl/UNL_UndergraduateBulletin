<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\Edition\Edition;
use UNL\Services\CourseApproval\XCRIService\XCRIServiceInterface;

class DataDriver implements XCRIServiceInterface
{
    protected $subjectAreas = [];

    protected $allCourses;

    protected $currentEdition;

    public function __construct(Edition $edition = null)
    {
        if (!$edition) {
            $edition = Controller::getEdition();
        }

        $this->currentEdition = $edition;
    }

    /**
     * Resets the internal caching members back to inital values
     * @return self
     */
    protected function reset()
    {
        unset($this->allCourses);
        $this->subjectAreas = [];

        return $this;
    }

    /**
     * Sets the bulletin edition to use course data from
     * @param Edition $edition
     * @return self
     */
    public function setEdition(Edition $edition)
    {
        // if changing years, reset internal caching members
        if ($this->currentEdition->getYear() != $edition->getYear()) {
            $this->reset();
        }

        $this->currentEdition = $edition;

        return $this;
    }

    public function getAllCourses()
    {
        if (!isset($this->allCourses)) {
            $cousePath = $this->currentEdition->getCourseDataDir();

            if (isset($_GET['format']) && $_GET['format'] == 'json') {
                $cousePath .= '/all-courses-min.xml';
            } else {
                $cousePath .= '/all-courses.xml';
            }

            $this->allCourses = file_get_contents($cousePath);
        }
        return $this->allCourses;
    }

    public function getSubjectArea($subjectarea)
    {
        if (!isset($this->subjectAreas[(string)$subjectarea])) {

            if (!preg_match('/^[A-Z]{3,4}$/', $subjectarea)) {
                throw new \Exception('Invalid subject code ' . $subjectarea, 404);
            }

            $file = $this->currentEdition->getCourseDataDir() . '/subjects/' . $subjectarea . '.xml';

            if (!file_exists($file)) {
                throw new \Exception('No subject area found matching '
                    . $subjectarea . ' in the '. $this->currentEdition->getYear() . ' edition.', 404);
            }

            $this->subjectAreas[(string)$subjectarea] = file_get_contents($file);
        }

        return $this->subjectAreas[(string)$subjectarea];
    }
}
