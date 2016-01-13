<?php
class UNL_UndergraduateBulletin_Developers_FourYearPlans
{
    public $title       = "Four Year Plans";
    
    public $uri         = "major/{major}/plans";
    
    public $exampleURI  = "major/Actuarial+Science+%28ASC%29/plans";
    
    public $properties  = array();
                                
    public $formats     = array("json", "partial");
    
    function __construct()
    {
        $this->uri         = UNL_UndergraduateBulletin_Controller::$url . $this->uri;
        $this->exampleURI  = UNL_UndergraduateBulletin_Controller::$url . $this->exampleURI;
    }
}