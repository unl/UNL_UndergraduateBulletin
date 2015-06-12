<?php
class UNL_UndergraduateBulletin_SubjectAreas extends ArrayIterator implements UNL_UndergraduateBulletin_CacheableInterface
{
    /**
     * Returns an array with subject code keys and title values
     *
     * @throws Exception
     * @return array
     */
    public static function getMap($edition = null)
    {
        if (!$edition) {
            $edition = UNL_UndergraduateBulletin_Controller::getEdition();
        }
        
        $mapping = file_get_contents($edition->getCourseDataDir() . '/subject_codes.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new Exception('Invalid major to subject code matching file.', 500);
        }
        
        return $mapping;
    }
    
    function __construct($options = array())
    {
        $this->options = $options;
        
        parent::__construct(self::getMap());
    }
    
    function getCacheKey()
    {
        return 'subjectareas'.$this->options['format'];
    }
    
    function preRun($fromCache, Savvy $savvy)
    {
        
    }
    
    function run()
    {
        
    }
    
    function current()
    {
        $options = array(
            'id' => $this->key(),
            'title' => parent::current(),
        );

        $area = new UNL_UndergraduateBulletin_SubjectArea($options);
        return $area;
    }
}