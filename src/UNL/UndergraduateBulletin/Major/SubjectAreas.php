<?php
class UNL_UndergraduateBulletin_Major_SubjectAreas extends ArrayIterator
{
    public $major;
    
    function __construct($major)
    {
        $subject_codes = array();
        $this->major = $major;
        $mapping = file_get_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/major_to_subject_code.php.ser');
        $mapping = unserialize($mapping);
        if (isset($mapping[$this->major->title])) {
            $subject_codes = $mapping[$this->major->title];
        }
        parent::__construct($subject_codes);
    }
    
    function current()
    {
        return new UNL_Services_CourseApproval_SubjectArea(parent::current());
    }
}
?>