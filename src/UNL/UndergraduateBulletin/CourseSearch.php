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
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            return false;
        }
        $result = socket_connect($socket, '127.0.0.1', 13212);
        if ($result === false) {
            return false;
        }

        socket_write($socket, json_encode($this->options)."\n", strlen(json_encode($this->options)."\n"));
        stream_set_timeout($socket, 2);

        $results = '';
        while ($line = socket_read($socket, 2048)) {
            $results .= $line;
        }

        socket_close($socket);

        return $results;
    }

    function count()
    {
        return count($this->results);
    }
}
