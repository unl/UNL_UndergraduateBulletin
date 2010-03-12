<?php
class UNL_UndergraduateBulletin_Listing
{
    protected $internal;
    
    function __construct($options = array())
    {
        $this->internal = new UNL_Services_CourseApproval_Listing($options['subjectArea'], $options['courseNumber']);
    }
    
    function __get($var)
    {
        return $this->internal->$var;
    }
}