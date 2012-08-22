<?php
class UNL_Services_CourseApproval_Search_Results extends UNL_Services_CourseApproval_Courses implements Countable
{
    protected $total;
    
    function __construct($results, $offset = 0, $limit = -1)
    {
        $this->total = count($results);

        if (
                $limit > 0
            &&
                $this->total < $offset + $limit
            ) {
            $results = array_slice($results, $offset, $limit);
        }

        parent::__construct($results);
    }
    
    function count()
    {
        return $this->total;
    }
}