<?php
/**
 * Collection of course codes for this course
 *
 * @author Brett Bieber <brett.bieber@gmail.com>
 */
class UNL_Services_CourseApproval_Course_Codes extends ArrayIterator
{
    protected $course;
    
	/**
	 * Array of results, usually from an xpath query
	 * 
	 * @param UNL_Services_CourseApproval_Course $course
	 * @param array $courseCodes
	 */
    function __construct(UNL_Services_CourseApproval_Course $course, $courseCodes)
    {
        $this->course = $course;
        
        $codes = array();
        foreach ($courseCodes as $code) {
            $codes[] = $code;
        }
        parent::__construct($codes);
    }

    /**
     * Get the listing
     *
     * @return UNL_Services_CourseApproval_Listing
     */
    function current()
    {
        $codeXml = parent::current();
        return $this->course->getListingFromCourseCode($codeXml);
    }

    /**
     * Get the course number
     * 
     * @return string course number
     */
    function key()
    {
        return $this->current()->courseNumber;
    }
}
