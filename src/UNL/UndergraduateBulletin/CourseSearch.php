<?php
class UNL_UndergraduateBulletin_CourseSearch
{

    public $results;
    
    function __construct($options = array())
    {
        $search = new UNL_Services_CourseApproval_Search();
        $this->results = $search->byNumber($options['q']);
    }
}
?>