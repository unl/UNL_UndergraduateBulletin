<?php
class UNL_UndergraduateBulletin_SubjectArea extends UNL_Services_CourseApproval_SubjectArea
{
    function __construct($options = array())
    {
        parent::__construct($options['id']);
    }
    
    /**
     * Get a subject area by full title
     *
     * @param string $title The full title
     * 
     * @return UNL_UndergraduateBulletin_SubjectArea
     */
    public static function getByTitle($title)
    {
        $title = trim(strtolower($title));
        $subject_areas = new UNL_UndergraduateBulletin_SubjectAreas();
        foreach ($subject_areas as $code=>$check_title) {
            if (strtolower($check_title) == $title) {
                return new self(array('id'=>$code));
            }
        }
        return false;
    }
}