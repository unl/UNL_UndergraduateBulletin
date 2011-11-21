<?php
class UNL_Services_CourseApproval_Course_Codes extends ArrayIterator
{
    
    function __construct($courseCodes)
    {
        $codes = array();
        foreach ($courseCodes as $code) {
            $codes[] = $code;
        }
        parent::__construct($codes);
    }
    
    function current()
    {
        $number = UNL_Services_CourseApproval_Course::courseNumberFromCourseCode(parent::current());
        return new UNL_Services_CourseApproval_Listing(parent::current()->subject,
                                                     $number,
                                                     UNL_Services_CourseApproval_Course::getListingGroups(parent::current()));
    }
    
    function key()
    {
        return $this->current()->courseNumber;
    }
}
