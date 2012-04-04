<?php

class UNL_UndergraduateBulletin_CourseDataDriver implements UNL_Services_CourseApproval_XCRIService
{
    protected $subjectAreas = array();

    protected $allCourses;

    function __construct()
    {
        
    }
    
    function getAllCourses()
    {
        if (!isset($this->allCourses)) {
            if (isset($_GET['format'])
                && $_GET['format'] == 'json') {
                $this->allCourses = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/all-courses-min.xml');
            }
            $this->allCourses = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/all-courses.xml');
        }
        return $this->allCourses;
    }
    
    function getSubjectArea($subjectarea)
    {
        if (!isset($this->subjectAreas[(string)$subjectarea])) {

            if (!preg_match('/^[A-Z]{3,4}$/', $subjectarea)) {
                throw new UnexpectedValueException('Invalid subject code '.$subjectarea, 400);
            }

            $file = UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/subjects/'.$subjectarea.'.xml';

            if (!file_exists($file)) {
                throw new Exception('No subject area found matching '.$subjectarea.' in the '.UNL_UndergraduateBulletin_Controller::getEdition()->getYear().' edition.', 404);
            }
            $this->subjectAreas[(string)$subjectarea] = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/subjects/'.$subjectarea.'.xml');
        }

        return $this->subjectAreas[(string)$subjectarea];
    }
}