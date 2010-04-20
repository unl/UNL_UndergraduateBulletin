<?php
class UNL_UndergraduateBulletin_Search
{
    public $options = array('q'=>'');

    /**
     * Course search results
     * @var UNL_UndergraduateBulletin_CourseSearch
     */
    public $courses;

    /**
     * Major search results
     * @var UNL_UndergraduateBulletin_MajorSearch
     */
    public $majors;
    
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

        $this->courses = new UNL_UndergraduateBulletin_CourseSearch($this->options);
        $this->majors  = new UNL_UndergraduateBulletin_MajorSearch($this->options);

    }

}