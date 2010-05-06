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
        $options = array('id'=>$data[0]);
        if (isset($data[1])) {
            $options['title'] = $data[1];
        }
        return new UNL_UndergraduateBulletin_SubjectArea($options);
    }
    
    function key()
    {
        $data = str_getcsv(parent::current(), ',', '\'');
        return $data[0];
    }
}