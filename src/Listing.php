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
    
    public function __construct($options = array())
    {
        $listing = $options;
        if (!$listing instanceof UNL_Services_CourseApproval_Listing) {
            $listing = UNL_Services_CourseApproval_Listing::createFromSubjectAndNumber($options['subjectArea'], $options['courseNumber']);
        }
        
        $this->internal = $listing;
        $this->course = $this->internal->course;
        $this->course->setRenderListing($listing);
    }
    
    public function getSubject()
    {
        return $this->internal->subjectArea;
    }
    
    public function getCourseNumber()
    {
        return $this->internal->courseNumber;
    }
    
    public function getURL()
    {
        return UNL_UndergraduateBulletin_Controller::getURL() 
            . 'courses/' . $this->internal->subjectArea . '/' . $this->internal->courseNumber;
    }
    
    public function getTitle()
    {
        return $this->internal->subjectArea . ' ' . $this->getListingNumbers() . ': ' . $this->course->title;
    }
    
    public function getCourseTitle()
    {
        return $this->internal->course->title;
    }
    
    public function getCourseNumberCssClass()
    {
        return 'l' . count($this->internal->getListingsFromSubject());
    }
    
    public function getCssClass()
    {
        $classes = array('course');
        
        $groups = $this->getCourseGroups();
        
        foreach ($groups as $group) {
            $classes[] = 'grp_' . md5($group);
        }
        
        foreach ($this->internal->course->getActivities() as $type => $activity) {
            $classes[] = $type;
        }
        unset($activity);
        
        if ($this->internal->course->getACEOutcomes()) {
            $classes[] = 'ace';
        }
        
        foreach ($this->internal->course->getACEOutcomes() as $outcome) {
            $classes[] = 'ace_' . $outcome;
        }
        
        return implode(' ', $classes);
    }
    
    public function getListingNumbers()
    {
        $listings = array();
        
        foreach ($this->internal->getListingsFromSubject() as $listing) {
            $listings[] = $listing->courseNumber;
        }
        
        sort($listings);
        return implode('/', $listings);
    }
    
    public function getCourseGroups()
    {
        $groups = array();
        foreach ($this->internal->getListingsFromSubject() as $listing) {
            if ($listing->hasGroups()) {
                foreach ($listing->groups as $group) {
                    $groups[] = (string) $group;
                }
            }
        }
        
        return array_unique($groups);
    }
    
    public function getCrosslistings()
    {
        $listings = $this->internal->getCrosslistingsBySubject();
        $subjectStrings = array();
        
        foreach ($listings as $subject => $subjectListings) {
            $listingNumbers = array();
            
            foreach ($subjectListings as $listing) {
                $listingNumbers[] = $listing->courseNumber;
            }
            
            $subjectStrings[] = $subject . ' ' . implode('/', $listingNumbers);
        }
        
        return implode(', ', $subjectStrings);
    }
    
    public function getSubsequentCourses($searcher)
    {
        $courses = $this->internal->getSubsequentCourses($searcher);
        return $courses;
    }
}
