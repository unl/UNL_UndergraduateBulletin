<?php
class UNL_UndergraduateBulletin_SubjectAreas extends ArrayIterator implements UNL_UndergraduateBulletin_CacheableInterface
{
    function __construct($options = array())
    {
        $this->options = $options;

        $mapping = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/creq/subject_codes.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new Exception('Invalid major to subject code matching file.', 500);
        }
        
        parent::__construct($mapping);
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
        $options = array('id' => $this->key(),
                         'title' => parent::current(),
        );

        try {
            $area = new UNL_UndergraduateBulletin_SubjectArea($options);
        } catch(Exception $e) {
            throw new Exception(
                'Error in ' . $this->getFilename().':'
                . ' subject area id "'.$data[0].'" with title "'.$data[1].'" is invalid.'
            , 500, $e);
        }
        return $area;
    }
}