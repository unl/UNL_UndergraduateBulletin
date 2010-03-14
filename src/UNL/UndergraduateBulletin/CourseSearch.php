<?php
class UNL_UndergraduateBulletin_CourseSearch
{

    public $results;
    
    public $options;
    
    function __construct($options = array())
    {
        $this->options = $options;

        $search = new UNL_Services_CourseApproval_Search();

        $this->results = $search->byAny($this->options['q']);

    }
}
?>