<?php 
class UNL_Services_CourseApproval_Listing
{
    
    /**
     * Internal subject area object
     * 
     * @var UNL_Services_CourseApproval_SubjectArea
     */
    protected $_subjectArea;
    
    /**
     * The subject area for this listing eg ACCT
     * 
     * @var string
     */
    public $subjectArea;
    
    /**
     * The course number eg 201
     * 
     * @var string|int
     */
    public $courseNumber;
    
    public $groups = array();
    
    function __construct($subject, $number, $groups = array())
    {
        $this->subjectArea  = $subject;
        $this->courseNumber = $number;
        $this->groups       = $groups;
    }
    
    function __get($var)
    {
        if ($var == 'course') {
            if (!isset($this->_subjectArea)) {
                $this->_subjectArea = new UNL_Services_CourseApproval_SubjectArea($this->subjectArea);
            }
            return $this->_subjectArea->courses[$this->courseNumber];
        }
        // Delegate to the course
        return $this->course->$var;
    }
    
    function __isset($var)
    {
        // Delegate to the course
        return isset($this->course->$var);
    }

    function hasGroups()
    {
        return count($this->groups)? true : false;
    }
}
