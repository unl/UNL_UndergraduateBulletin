<?php
class UNL_UndergraduateBulletin_Developers_Course
{
    public $title       = "Course";
    
    public $uri         = "courses/{subjectArea}/{course number}";
    
    public $exampleURI  = "courses/ECON/211";
    
    public $properties  = array(
                                array("title", "(String) The title of the course", true, true),
                                array("description", "(String) The course description", true, true),
                                array("prerequisite", "(String) The prerequisite for joining the course", true, true),
                                array("courseCodes", "(String) A list of the course codes belonging to the course.", true, true),
                                array("gradingType", "(String) The gradingType of the course.", false, true),
                                array("dfRemoval", "(bool) D or F removal", false, true),
                                array("effectiveSemester", "(int) The effective semester of the course.", false, true),
                                array("notes", "(String) Notes about the course.", false, true),
                                array("campus", "(String) The campus that the course is located at.", false, true),
                                array("deliveryMethods", "(String) A list of delivery methods for the course.", false, true),
                                array("termsOffered", "(String) a list of terms that the course is avaibale during.", false, true),
                                array("activities", "(String) A list of activites for the course, ie: lecture and recitation.", false, true),
                                array("credits", "(int) The credits that the course is worth.", false, true),
                                array("aceOutcomes", "(int) a list of ace outcomes for the course.", false, true),
                                );
                                
    public $formats     = array("json", "xml", "partial");
    
    function __construct()
    {
        $this->uri         = UNL_UndergraduateBulletin_Controller::$url . $this->uri;
        $this->exampleURI  = UNL_UndergraduateBulletin_Controller::$url . $this->exampleURI;
    }
}