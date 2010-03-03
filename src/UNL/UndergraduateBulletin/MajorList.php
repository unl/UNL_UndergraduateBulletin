<?php
class UNL_UndergraduateBulletin_MajorList extends ArrayIterator
{
    function __construct()
    {
        $majors = glob(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/*.epub');
        return parent::__construct($majors);
    }
    
    function current()
    {
        return str_replace(array(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/', '.epub'), '', parent::current());
    }
}
?>