<?php
class UNL_UndergraduateBulletin_OtherAreas extends ArrayIterator  implements UNL_UndergraduateBulletin_CacheableInterface
{
    public $options = array('format'=>'html');

    function __construct($options = array())
    {
        $this->options = $options + $this->options;
        $otherareas = glob(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/other/*.xhtml');
        return parent::__construct($otherareas);
    }

    function getCacheKey()
    {
        return 'otherlist'.$this->options['format'];
    }

    function run()
    {
        
    }

    function preRun($fromCache, Savvy $savvy)
    {
        
    }

    function current()
    {
        $name = UNL_UndergraduateBulletin_EPUB_Utilities::getNameByFile(parent::current());

        return new UNL_UndergraduateBulletin_OtherArea(array('name'=>$name));
    }
}
