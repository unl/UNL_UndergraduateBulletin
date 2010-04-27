<?php
class UNL_UndergraduateBulletin_Search implements UNL_UndergraduateBulletin_CacheableInterface
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

    }
    
    function getCacheKey()
    {
        return 'overallsearch'.$this->options['q'].$this->options['format'];
    }
    
    function preRun()
    {

    }
    
    function run()
    {
        $this->courses = new UNL_UndergraduateBulletin_CourseSearch($this->options);
        $this->courses->run();
        $this->majors  = new UNL_UndergraduateBulletin_MajorSearch($this->options);
    }

}