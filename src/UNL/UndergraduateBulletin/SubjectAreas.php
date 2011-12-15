<?php
class UNL_UndergraduateBulletin_SubjectAreas extends SplFileObject implements UNL_UndergraduateBulletin_CacheableInterface
{
    function __construct($options = array())
    {
    	$this->options = $options;
        parent::__construct(
            UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/subject_codes.csv'
        );
        $this->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        $this->setCsvControl(',', '\'');
    }
    
    function getCacheKey()
    {
        return 'subjectareas'.$this->options['format'];
    }
    
    function preRun()
    {
        
    }
    
    function run()
    {
        
    }
    
    function current()
    {
        $data = parent::current();

        $options = array('id' => $data[0]);
        if (isset($data[1])) {
            $options['title'] = $data[1];
        }

        return new UNL_UndergraduateBulletin_SubjectArea($options);
    }
    
    function key()
    {
        $data = parent::current();
        return $data[0];
    }
}