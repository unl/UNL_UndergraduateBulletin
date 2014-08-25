<?php
class UNL_UndergraduateBulletin_MajorList extends ArrayIterator  implements 
    UNL_UndergraduateBulletin_CacheableInterface,
    UNL_UndergraduateBulletin_ControllerAwareInterface
    
{
    public $options = array('format'=>'html');
    
    protected $controller;

    function __construct($options = array())
    {
        $this->options = $options + $this->options;
        $majors = glob(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/majors/*.xhtml');
        return parent::__construct($majors);
    }
    
    public function setController(UNL_UndergraduateBulletin_Controller $controller)
    {
        $this->controller = $controller;
        return $this;
    }
    
    public function getController()
    {
        return $this->controller;
    }

    function getCacheKey()
    {
        return 'majorlist'.$this->options['format'];
    }

    function run()
    {
        
    }

    function preRun($fromCache, Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', '');
        
        $pagetitle = '<h1>Majors/Areas of Study</h1>';
        $controller::setReplacementData('pagetitle', $pagetitle);
        
        $controller::setReplacementData('breadcrumbs', <<<EOD
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="{$controller::getURL()}">Undergraduate Bulletin</a></li>
    <li>Majors/Areas of Study</li>
</ul>
EOD
        );
    }

    function current()
    {

        $name = UNL_UndergraduateBulletin_EPUB_Utilities::getNameByFile(parent::current());

        return new UNL_UndergraduateBulletin_Major(array('name'=>$name));
    }
}
