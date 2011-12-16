<?php
/**
 * Collection of course codes for this course
 *
 * @author Brett Bieber <brett.bieber@gmail.com>
 */
class UNL_Services_CourseApproval_Course_Codes extends ArrayIterator
{

	/**
	 * Array of results, usually from an xpath query
	 * 
	 * @param array $courseCodes
	 */
    function __construct($courseCodes)
    {
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
        $number = UNL_Services_CourseApproval_Course::courseNumberFromCourseCode(parent::current());
        return new UNL_Services_CourseApproval_Listing(parent::current()->subject,
                                                     $number,
                                                     UNL_Services_CourseApproval_Course::getListingGroups(parent::current()));
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
