<?php
class UNL_UndergraduateBulletin_Developers_SubjectArea
{
    public $title       = "Subject Area";
    
    public $uri         = "courses/{subjectArea}";
    
    public $exampleURI  = "courses/ECON";
    
    public $properties  = array(
                                array("id", "(String) The subject code", true, true),
                                array("title", "(String) The title of the subject area", true, true),
                                array("courses", "(Array) The courses", true, true),
                                );
                                
    public $formats     = array("json", "xml", "partial");
    
    function __construct()
    {
        $this->uri         = UNL_UndergraduateBulletin_Controller::$url . $this->uri;
        $this->exampleURI  = UNL_UndergraduateBulletin_Controller::$url . $this->exampleURI;
    }
}