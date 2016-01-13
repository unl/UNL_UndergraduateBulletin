<?php
class UNL_UndergraduateBulletin_Developers_CourseSearch
{
    public $title       = "Course Search Results";
    
    public $uri         = "courses/search/?q={search query}";
    
    public $exampleURI  = "courses/search/?q=fish";
    
    public $properties  = array();
                                
    public $formats     = array("json", "xml", "partial");
    
    function __construct()
    {
        $this->uri         = UNL_UndergraduateBulletin_Controller::$url . $this->uri;
        $this->exampleURI  = UNL_UndergraduateBulletin_Controller::$url . $this->exampleURI;
    }
}