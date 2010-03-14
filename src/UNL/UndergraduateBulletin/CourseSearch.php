<?php
class UNL_UndergraduateBulletin_CourseSearch
{

    public $results;
    
    public $options = array('q'      => null,
                            'offset' => 0,
                            'limit'  => 15);
    
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

        $search = new UNL_Services_CourseApproval_Search();

        $this->results = $search->byAny($this->options['q'], $this->options['offset'], $this->options['limit']);

    }
}
?>