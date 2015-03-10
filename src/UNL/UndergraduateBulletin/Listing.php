<?php
class UNL_UndergraduateBulletin_Listing
{
    /**
     * @var UNL_Services_CourseApproval_Listing
     */
    protected $internal;
    
    /**
     * Cached version of the internal course
     *
     * @var UNL_Services_CourseApproval_Course
     */
    public $course;
    
    function __construct($options = array())
    {
        $this->internal = new UNL_Services_CourseApproval_Listing($options['subjectArea'], $options['courseNumber']);
        $this->course = $this->internal->course;
        $this->course->subject = $this->internal->subjectArea;
    }
    
    public function getURL()
    {
        return UNL_UndergraduateBulletin_Controller::getURL() 
            . 'courses/' . $this->internal->subjectArea . '/' . $this->internal->courseNumber;
    }
    
    public function getTitle()
    {
        return $this->internal->subjectArea . ' ' . $this->getCourseListings() . ': ' . $this->course->title;
    }
    
    protected function getCourseListings()
    {
        $listings = array();
        
        foreach ($this->course->codes as $listing) {
            if ($this->internal->subjectArea != (string)$listing->subjectArea) {
                continue;
            }
            
            $listings[] = $listing->courseNumber;
        }
        
        sort($listings);
        return implode('/', $listings);
    }
}
