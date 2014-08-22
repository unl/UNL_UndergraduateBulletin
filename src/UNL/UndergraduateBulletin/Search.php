<?php
class UNL_UndergraduateBulletin_Search implements
    UNL_UndergraduateBulletin_CacheableInterface,
    UNL_UndergraduateBulletin_ControllerAwareInterface
{
    public $options = array('q'=>'');

    /**
     * Course search results
     * @var UNL_UndergraduateBulletin_CourseSearch
     */
    public $courses;

    /**
     * Major search results
     * @var UNL_UndergraduateBulletin_MajorSearch
     */
    public $majors;
    
    protected $controller;
    
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

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
        return 'overallsearch'.$this->options['q'].$this->options['format'];
    }
    
    function preRun($fromCache, Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', 'Search | Undergraduate Bulletin | University of Nebraska-Lincoln');
        
        $pagetitle = '<h1>Search</h1>';
        $controller::setReplacementData('pagetitle', $pagetitle);
        
        $controller::setReplacementData('breadcrumbs', <<<EOD
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="{$controller::getURL()}">Undergraduate Bulletin</a></li>
    <li>Search</li>
</ul>
EOD
        );
    }
    
    function run()
    {
        $this->courses = new UNL_UndergraduateBulletin_CourseSearch($this->options);
        $this->courses->run();
        $this->majors  = new UNL_UndergraduateBulletin_MajorSearch($this->options);
    }

}