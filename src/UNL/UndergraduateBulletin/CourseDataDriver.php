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
                $this->allCourses = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/creq/all-courses-min.xml');
            }
            $this->allCourses = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/creq/all-courses.xml');
        }
        return $this->allCourses;
    }
    
    function getSubjectArea($subjectarea)
    {
        if (!isset($this->subjectAreas[(string)$subjectarea])) {

            $file = UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/creq/subjects/'.$subjectarea.'.xml';
            if (!preg_match('/^[A-Z]{3,4}$/', $subjectarea) || !file_exists($file)) {
                throw new Exception('No subject area found matching '.$subjectarea.'.', 404);
            }
          $this->subjectAreas[(string)$subjectarea] = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/creq/subjects/'.$subjectarea.'.xml');
        }

        return $this->subjectAreas[(string)$subjectarea];
    }
}