<?php
class UNL_UndergraduateBulletin_SubjectAreas extends ArrayIterator
{
    function __construct()
    {
        parent::__construct(
            file(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/subject_codes.csv')
        );
    }
    
    function current()
    {
        $data = explode(',', parent::current());
        if (isset($data[1])) {
            return $data[1];
        }
        return $data[0];
    }
    
    function key()
    {
        $data = explode(',', parent::current());
        return $data[0];
    }
}