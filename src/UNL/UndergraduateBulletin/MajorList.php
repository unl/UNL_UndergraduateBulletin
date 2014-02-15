<?php
class UNL_UndergraduateBulletin_MajorList extends ArrayIterator  implements UNL_UndergraduateBulletin_CacheableInterface
{
    public $options = array('format'=>'html');

    function __construct($options = array())
    {
        $this->options = $options + $this->options;
        $majors = glob(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/majors/*.xhtml');
        return parent::__construct($majors);
    }

    function getCacheKey()
    {
        return 'majorlist'.$this->options['format'];
    }

    function run()
    {
        
    }

    function preRun()
    {
        
    }

    function current()
    {

        $name = UNL_UndergraduateBulletin_EPUB_Utilities::getNameByFile(parent::current());

        return new UNL_UndergraduateBulletin_Major(array('name'=>$name));
    }
}
