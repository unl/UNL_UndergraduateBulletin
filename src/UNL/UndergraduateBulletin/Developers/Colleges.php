<?php
class UNL_UndergraduateBulletin_Developers_Colleges
{
    public $title       = "Colleges";
    
    public $uri         = "college";
    
    public $exampleURI  = "college";
    
    public $properties  = array(
                                array("abbreviation", "(String) The abbreviation of the college", true, true),
                                array("name", "(String) The college name", true, true),
                                array("uri", "(String) URI to the college", true, true),
                                );
                                
    public $formats     = array("json", "partial");
    
    function __construct()
    {
        $this->uri = "http://" . $_SERVER['SERVER_NAME'].UNL_UndergraduateBulletin_Controller::$url . $this->uri;
        $this->exampleURI  = "http://" . $_SERVER['SERVER_NAME'].UNL_UndergraduateBulletin_Controller::$url . $this->exampleURI;
    }
}