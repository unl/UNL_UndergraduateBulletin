<?php
class UNL_UndergraduateBulletin_CourseSearch implements 
    Countable, 
    UNL_UndergraduateBulletin_CacheableInterface,
    UNL_UndergraduateBulletin_ControllerAwareInterface
{

    public $results;

    public $options = array('q'      => null,
                            'offset' => 0,
                            'limit'  => 15);
    
    protected $controller;

    function __construct($options = array())
    {
        $this->options = $options + $this->options;

    }
    
    public function setController(UNL_UndergraduateBulletin_Controller $controller) {
        $this->controller = $controller;
        return $this;
    }
    
    
    public function getController() {
        return $this->controller;
    }

    function getCacheKey()
    {
        return 'coursesearch'.serialize($this->options);
    }

    function preRun($fromCache, Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', 'Course Search | Undergraduate Bulletin | University of Nebraska-Lincoln');
        
        $pagetitle = '<h1>Course Search</h1>';
        $controller::setReplacementData('pagetitle', $pagetitle);
        
        $controller::setReplacementData('breadcrumbs', <<<EOD
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="{$controller::getURL()}">Undergraduate Bulletin</a></li>
    <li><a href="{$controller::getURL()}courses/">Courses</a></li>
    <li>Search</li>
</ul>
EOD
        );
    }

    function run()
    {
        $driver = null;
        if (file_exists(UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/courses.sqlite')) {
            $driver = new UNL_UndergraduateBulletin_CourseSearch_DBSearcher();
        }

        $search = new UNL_Services_CourseApproval_Search($driver);

        if (preg_match('/^([A-Z]{3,4})(\s*:\s*.*)?$/i', $this->options['q'], $matches)
            && file_exists(UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/subjects/'.strtoupper($matches[1]).'.xml')) {
            // There is a subject code prefix, only search the subject code
            $this->options['q'] = strtoupper($matches[1]);
            $this->results = $search->bySubject(strtoupper($matches[1]),
                                        $this->options['offset'],
                                        $this->options['limit']);
            return;
        }

        // Check to see if the query matches the full description of a subject code
        if ($area = UNL_UndergraduateBulletin_SubjectArea::getByTitle($this->options['q'])) {
            $this->options['q'] = $area->subject.' : '.$area->title;
            $this->results = $search->bySubject($area->subject, $this->options['offset'], $this->options['limit']);
            return;
        }

        $this->results = $search->byAny($this->options['q'],
                                        $this->options['offset'],
                                        $this->options['limit']);
    }

    /**
     * Get the filters used for this search
     *
     * @return UNL_UndergraduateBulletin_CourseSearch_Filters
     */
    public function getFilters()
    {
        return new UNL_UndergraduateBulletin_CourseSearch_Filters($this->options);
    }


    function count()
    {
        return count($this->results);
    }
}
