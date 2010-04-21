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
        $search = new UNL_Services_CourseApproval_Search();

        $this->results = $search->byAny($this->options['q'],
                                        $this->options['offset'],
                                        $this->options['limit']);
    }

    function count()
    {
        return count($this->results);
    }
}
?>