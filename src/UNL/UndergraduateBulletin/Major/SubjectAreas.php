<?php
class UNL_UndergraduateBulletin_Major_SubjectAreas extends ArrayIterator
{
    public $major;
    
    function __construct($major)
    {
        $subject_codes = array();
        $this->major = $major;
        switch ($this->major->title) {
            case 'Accounting':
                $subject_codes[] = 'ACCT';
                break;
            case 'Advertising':
                $subject_codes[] = 'ADVT';
                break;
            case 'Geography':
                $subject_codes[] = 'GEOG';
                break;
            case 'Agribusiness':
                $subject_codes[] = 'AGRI';
                //$subject_codes[] = 'AECN';
                break;
            case 'Architecture':
                $subject_codes[] = 'ARCH';
                break;
        }
        parent::__construct($subject_codes);
    }
    
    function current()
    {
        return new UNL_Services_CourseApproval_SubjectArea(parent::current());
    }
}
?>