<?php

namespace UNL\UndergraduateBulletin;

class Search implements
    CachingService\CacheableInterface,
    ControllerAwareInterface
{
    public $options = ['q' => ''];

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

    public function __construct($options = [])
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

    public function getCacheKey()
    {
        return 'overallsearch'.$this->options['q'].$this->options['format'];
    }

    public function preRun($fromCache, Savvy $savvy)
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

    public function run()
    {
        $this->courses = new UNL_UndergraduateBulletin_CourseSearch($this->options);
        $this->courses->run();
        $this->majors  = new UNL_UndergraduateBulletin_MajorSearch($this->options);
    }
}
