<?php 
/**
 * A representation of a course code
 * 
 * @property UNL_Services_CourseApproval_Course $course The course
 */
class UNL_Services_CourseApproval_Listing
{
    /**
     * The subject area for this listing eg ACCT
     * 
     * @var string
     */
    public $subjectArea;
    
    /**
     * The course number eg 201
     * 
     * @var string
     */
    public $courseNumber;
    
    public $type;
    
    public $groups = array();
    
    /**
     * @param string $subject
     * @param string $number
     * @return self
     */
    public static function createFromSubjectAndNumber($subject, $number)
    {
        $number = (string) $number;
        $subjectArea = new UNL_Services_CourseApproval_SubjectArea($subject);
        $course = $subjectArea->courses[$number];
        
        /* @var $course UNL_Services_CourseApproval_Course */
        /* @var $candidateListing self */
        foreach ($course->codes as $candidateListing) {
            if ($candidateListing->subjectArea === $subject && $candidateListing->courseNumber === $number) {
                return $candidateListing;
            }
        }
        
        return null;
    }
    
    /**
     * @param UNL_Services_CourseApproval_Course $course
     * @param string $subject
     * @param string $number
     * @param string $type
     * @param string[] $groups
     */
    public function __construct(UNL_Services_CourseApproval_Course $course, $subject, $number, $type, $groups)
    {
        $this->_course = $course;
        $this->subjectArea = (string) $subject;
        $this->courseNumber = (string) $number;
        $this->groups = (array) $groups;
        $this->type = (string) $type;
    }
    
    public function __get($var)
    {
        if ($var === 'course') {
            return $this->_course;
        }
        
        // Delegate to the course
        return $this->_course->$var;
    }
    
    public function __isset($var)
    {
        // Delegate to the course
        return isset($this->_course->$var);
    }
    
    /**
     * @return UNL_Services_CourseApproval_Listing[]
     */
    public function getListingsFromSubject()
    {
        $listings = array();
        
        foreach ($this->course->codes as $listing) {
            if ($this->subjectArea !== $listing->subjectArea) {
                continue;
            }
        
            $listings[] = $listing;
        }
        
        return $listings;
    }
    
    /**
     * @return UNL_Services_CourseApproval_Listing[]
     */
    public function getCrosslistingsBySubject()
    {
        $listings = array();
        
        foreach ($this->course->codes as $listing) {
            if ($this->subjectArea === $listing->subjectArea) {
                continue;
            }
            
            if (!isset($listings[$listing->subjectArea])) {
                $listings[$listing->subjectArea] = array();
            }
            
            $listings[$listing->subjectArea][] = $listing;
        }
        
        return $listings;
    }
    
    public function isCrosslisting()
    {
        return $this->type === UNL_Services_CourseApproval_Course::COURSE_CODE_TYPE_CROSS;
    }
    
    /**
     * Search for subsequent courses based on listing type
     * (reverse prereqs)
     *
     * @param UNL_Services_CourseApproval_Search $search_driver
     * @return UNL_Services_CourseApproval_Courses
     */
    public function getSubsequentCourses($search_driver = null)
    {
        if (!$this->isCrosslisting()) {
            return $this->_course->getSubsequentCourses($search_driver);
        }
        
        $searcher = new UNL_Services_CourseApproval_Search($search_driver);
        $query = $this->subjectArea . ' ' . $this->courseNumber;
        return $searcher->byPrerequisite($query);
    }

    public function hasGroups()
    {
        return !empty($this->groups);
    }
}
