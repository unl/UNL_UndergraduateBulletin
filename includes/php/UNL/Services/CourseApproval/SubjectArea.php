<?php 
class UNL_Services_CourseApproval_SubjectArea
{
    public $subject;

    /**
     * Collection of courses
     * 
     * @var UNL_Services_CourseApproval_SubjectArea_Courses
     */
    public $courses;
    
    /**
     * array of groups if any
     * @var UNL_Services_CourseApproval_SubjectArea_Groups
     */
    public $groups;
    
    function __construct($subject)
    {
        $this->subject = $subject;
        $this->courses = new UNL_Services_CourseApproval_SubjectArea_Courses($this);
        $groups = new UNL_Services_CourseApproval_SubjectArea_Groups($this);
        $this->groups = $groups->groups;
    }
    
    function __toString()
    {
        return $this->subject;
    }
}
