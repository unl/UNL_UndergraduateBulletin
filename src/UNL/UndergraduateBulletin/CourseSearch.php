<?php
class UNL_UndergraduateBulletin_CourseSearch
{

    public $results;
    
    function __construct($options = array())
    {
        $search = new UNL_Services_CourseApproval_Search();
        
        $parts = explode(' ', $options['q']);
        foreach ($parts as $part) {
            switch(true) {
                case preg_match('/([0-9]{2,3}[A-Z]?)/', $part):
                    $this->results = $search->byNumber($part);
                    break;
                case preg_match('/([A-Z]{2,3})/i', $part):
                    $this->results = $search->bySubject($part);
                    break;
            }
        }
        
    }
}
?>