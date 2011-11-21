<?php 
class UNL_Services_CourseApproval_XCRIService_creq implements UNL_Services_CourseApproval_XCRIService
{
    const URL = 'http://creq.unl.edu/courses/public-view/all-courses';
    
    /**
     * The caching service.
     * 
     * @var UNL_Services_CourseApproval_CachingService
     */
    protected $_cache;
    
    function __construct()
    {
        $this->_cache = UNL_Services_CourseApproval::getCachingService();
    }
    
    function getAllCourses()
    {
        return $this->_getData('creq_allcourses', self::URL);
    }
    
    function getSubjectArea($subjectarea)
    {
        return $this->_getData('creq_subject_'.$subjectarea, self::URL.'/subject/'.$subjectarea);
    }
    
    protected function _getData($key, $url)
    {
        if ($data = $this->_cache->get($key)) {
            return $data;
        }
        
        if ($data = file_get_contents($url)) {
            if ($this->_cache->save($key, $data)) {
                return $data;
            }
            throw new Exception('Could not save data for '.$url);
        }
        
        throw new Exception('Could not get data from '.$url);
    }
}
?>