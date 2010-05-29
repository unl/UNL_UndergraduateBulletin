<?php
class UNL_UndergraduateBulletin_MajorSearch extends ArrayIterator
{
    public $options = array('q'=>'');
    
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

        $this->options['q'] = str_replace(array('..', DIRECTORY_SEPARATOR), '', trim($this->options['q']));

        $query = preg_replace_callback('/([a-z])/i', function($matches) { return '['.strtolower($matches[0]).strtoupper($matches[0]).']'; }, $this->options['q']);
        $majors = glob(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/*'.$query.'*.xhtml');

        return parent::__construct($majors);
    }
    
    function current()
    {
        return new UNL_UndergraduateBulletin_Major(array('name'=>UNL_UndergraduateBulletin_Major_Description::getNameByFile(parent::current())));
    }
}
