<?php

class UNL_UndergraduateBulletin_CourseDataDriver implements UNL_Services_CourseApproval_XCRIService
{
    function __construct()
    {
        
    }
    
    function getAllCourses()
    {
        if (isset($_GET['format'])
            && $_GET['format'] == 'json') {
            return file_get_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/all-courses-min.xml');
        }
        return file_get_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/all-courses.xml');
    }
    
    function getSubjectArea($subjectarea)
    {
        $file = UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/subjects/'.$subjectarea.'.xml';
        if (!preg_match('/^[A-Z]{3,4}$/', $subjectarea) || !file_exists($file)) {
            throw new Exception('No subject area found matching '.$subjectarea.'.');
        }
        return file_get_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/subjects/'.$subjectarea.'.xml');
    }
}