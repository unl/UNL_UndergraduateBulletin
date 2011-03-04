<?php
class UNL_UndergraduateBulletin_Developers_Course
{
    public $title       = "Course";
    
    public $uri         = "courses/{subjectArea}/{course number}";
    
    public $exampleURI  = "courses/ECON/211";
    
    public $properties  = array(
                                array("dn", "(String) Distinguished name", true, true),
                                );
                                
    public $formats     = array("json", "xml", "partial");
    
    function __construct()
    {
        $this->uri = "http://" . $_SERVER['SERVER_NAME'].UNL_UndergraduateBulletin_Controller::$url . $this->uri;
        $this->exampleURI  = "http://" . $_SERVER['SERVER_NAME'].UNL_UndergraduateBulletin_Controller::$url . $this->exampleURI;
    }
}