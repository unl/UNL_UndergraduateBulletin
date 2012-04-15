<?php
class UNL_UndergraduateBulletin_SubjectArea extends UNL_Services_CourseApproval_SubjectArea
{
    public $title;
    
    function __construct($options = array())
    {
        if (isset($options['title'])) {
            $this->title = $options['title'];
        }
        parent::__construct($options['id']);
        $this->courses = new UNL_Services_CourseApproval_Filter_ExcludeGraduateCourses($this->courses);
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
        foreach ($subject_areas as $code => $area) {
            if (strtolower($area->title) == $title) {
                return $area;
            }
        }
        return false;
    }
    
    function __toString()
    {
        return $this->subject;
    }
}