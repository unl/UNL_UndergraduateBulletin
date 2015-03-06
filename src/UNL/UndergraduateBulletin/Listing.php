<?php
class UNL_UndergraduateBulletin_Listing
{
    protected $internal;
    
    function __construct($options = array())
    {
        $this->internal = new UNL_Services_CourseApproval_Listing($options['subjectArea'], $options['courseNumber']);
    }
    
    function __get($var)
    {
        return $this->internal->$var;
    }
    
    public function getURL()
    {
        return UNL_UndergraduateBulletin_Controller::getURL() 
            . 'courses/' . $this->internal->subjectArea . '/' . $this->internal->courseNumber;
    }
    
    public function getTitle()
    {
        return $this->internal->subjectArea . ' ' . $this->getCourseListings() . ': ' . $this->internal->course->title;
    }
    
    protected function getCourseListings()
    {
        $listings = array();
        
        foreach ($this->internal->course->codes as $listing) {
            if ($this->internal->subjectArea != (string)$listing->subjectArea) {
                continue;
            }
            
            $listings[] = $listing->courseNumber;
        }
        
        sort($listings);
        return implode('/', $listings);
    }
}
