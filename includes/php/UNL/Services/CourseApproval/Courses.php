<?php

class UNL_Services_CourseApproval_Courses extends ArrayIterator
{
    
    function __construct($courses)
    {
        parent::__construct($courses);
    }
    
    /**
     * Get the current course
     * 
     * @return UNL_Services_CourseApproval_Course
     */
    function current()
    {
        return new UNL_Services_CourseApproval_Course(parent::current());
    }
}