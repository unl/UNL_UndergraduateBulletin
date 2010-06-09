<?php
class UNL_UndergraduateBulletin_CourseSearch implements Countable, UNL_UndergraduateBulletin_CacheableInterface
{

    public $results;
    
    public $options = array('q'      => null,
                            'offset' => 0,
                            'limit'  => 15);
    
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

    }
    
    function getCacheKey()
    {
        return 'coursesearch'.serialize($this->options);
    }
    
    function preRun()
    {
        
    }
    
    function run()
    {
        $driver = null;
        if (file_exists(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/courses.sqlite')) {
            $driver = new UNL_UndergraduateBulletin_CourseSearch_DBSearcher();
        }

        $search = new UNL_Services_CourseApproval_Search($driver);

        if (preg_match('/^([A-Z]{3,4})(\s*:\s*.*)?$/i', $query, $matches)
            && file_exists(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/subjects/'.strtoupper($matches[1]).'.xml')) {
            $this->options['q'] = strtoupper($matches[1]);
            $this->results = $search->bySubject(strtoupper($matches[1]));
            return;
        }

        // Check to see if the query matches a subject code
        if ($area = UNL_UndergraduateBulletin_SubjectArea::getByTitle($this->options['q'])) {
            $this->options['q'] = $area->subject.' : '.$area->title;
        }

        $this->results = $search->byAny($this->options['q'],
                                        $this->options['offset'],
                                        $this->options['limit']);
    }


    function count()
    {
        return count($this->results);
    }
}
