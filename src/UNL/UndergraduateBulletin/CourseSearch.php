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
        // Try the service
        if ($results = $this->getServiceResults()) {
            $this->results = $results;
            return;
        }

        $search = new UNL_Services_CourseApproval_Search();

        $query = $this->options['q'];

        // Check to see if the query matches a subject code
        if ($area = UNL_UndergraduateBulletin_SubjectArea::getByTitle($query)) {
            $this->options['q'] = $area->subject.' : '.ucwords($this->options['q']);
            $query = $area->subject;
        }

        $this->results = $search->byAny($this->options['q'],
                                        $this->options['offset'],
                                        $this->options['limit']);
    }
    
    function getServiceResults()
    {

        $ports = range(13200, 13210);
        shuffle($ports);

        foreach ($ports as $port) {
            if ($fp = fsockopen('127.0.0.1', $port, $errno, $errstr, 5)) {
                break;
            }
        }

        if ($fp === false) {
            return false;
        }

        fwrite($fp, json_encode($this->options)."\n");

        $results = '';
        while (!feof($fp)) {
            $results .= fgets($fp, 128);
        }

        fclose($fp);

        return $results;
    }

    function count()
    {
        return count($this->results);
    }
}
