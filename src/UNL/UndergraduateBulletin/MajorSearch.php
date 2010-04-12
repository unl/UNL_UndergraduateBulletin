<?php
class UNL_UndergraduateBulletin_MajorSearch extends ArrayIterator
{
    public $options = array('q');
    
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

        $this->options['q'] = str_replace(array('..', DIRECTORY_SEPARATOR), '', trim($this->options['q']));

        $majors = glob(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/*'.$this->options['q'].'*.epub');

        return parent::__construct($majors);
    }
    
    function current()
    {
        return new UNL_UndergraduateBulletin_Major(array('name'=>UNL_UndergraduateBulletin_Major_Description::getNameByFile(parent::current())));
    }
}
?>