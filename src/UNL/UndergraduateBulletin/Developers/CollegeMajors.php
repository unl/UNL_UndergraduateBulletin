<?php
class UNL_UndergraduateBulletin_Developers_CollegeMajors
{
    public $title       = "Majors for a Specific College";
    
    public $uri         = "college/{collegeName}/majors";
    
    public $exampleURI  = "college/Engineering/majors";
    
    public $properties  = array();
                                
    public $formats     = array("json", "partial");
    
    function __construct()
    {
        $this->uri = "http://" . $_SERVER['SERVER_NAME'].UNL_UndergraduateBulletin_Controller::$url . $this->uri;
        $this->exampleURI  = "http://" . $_SERVER['SERVER_NAME'].UNL_UndergraduateBulletin_Controller::$url . $this->exampleURI;
    }
}