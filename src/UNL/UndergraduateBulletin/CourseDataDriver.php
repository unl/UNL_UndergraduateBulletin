<?php

class UNL_UndergraduateBulletin_CourseDataDriver implements UNL_Services_CourseApproval_XCRIService
{
    function __construct()
    {
        
    }
    
    function getAllCourses()
    {
        return file_get_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/all-courses.xml');
    }
    
    function getSubjectArea($subjectarea)
    {
        return file_get_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/subjects/'.$subjectarea.'.xml');
    }
}