<?php

class UNL_UndergraduateBulletin_CourseDataDriver implements UNL_Services_CourseApproval_XCRIService
{
    protected $subjectAreas = array();

    protected $allCourses;

    protected $currentEdition;

    public function __construct(UNL_UndergraduateBulletin_Edition $edition = null)
    {
        if (!$edition) {
            $edition = UNL_UndergraduateBulletin_Controller::getEdition();
        }

        $this->currentEdition = $edition;
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
                throw new UnexpectedValueException('Invalid subject code ' . $subjectarea, 400);
            }

            $file = $this->currentEdition->getCourseDataDir() . '/subjects/' . $subjectarea . '.xml';

            if (!file_exists($file)) {
                throw new Exception('No subject area found matching ' . $subjectarea . ' in the '. $this->currentEdition->getYear() . ' edition.', 404);
            }

            $this->subjectAreas[(string)$subjectarea] = file_get_contents($file);
        }

        return $this->subjectAreas[(string)$subjectarea];
    }
}
