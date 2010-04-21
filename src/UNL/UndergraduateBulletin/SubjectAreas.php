<?php
class UNL_UndergraduateBulletin_SubjectAreas extends ArrayIterator implements UNL_UndergraduateBulletin_CacheableInterface
{
    function __construct($options = array())
    {
        parent::__construct(
            file(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/subject_codes.csv')
        );
    }
    
    function getCacheKey()
    {
        return 'subjectareas';
    }
    
    function preRun()
    {
        
    }
    
    function run()
    {
        
    }
    
    function current()
    {
        $data = str_getcsv(parent::current(), ',', '\'');
        if (isset($data[1])) {
            return $data[1];
        }
        return $data[0];
    }
    
    function key()
    {
        $data = str_getcsv(parent::current(), ',', '\'');
        return $data[0];
    }
}