<?php
/**
 * Course data driver for the Course Requisition system at UNL (CREQ)
 * 
 * @author Brett Bieber <brett.bieber@gmail.com>
 */
class UNL_Services_CourseApproval_XCRIService_creq implements UNL_Services_CourseApproval_XCRIService
{

    /**
     * URL to the public creq XML data service endpoint
     * 
     * @var string
     */
    const URL = 'http://creq.unl.edu/courses/public-view/all-courses';

    /**
     * The caching service.
     * 
     * @var UNL_Services_CourseApproval_CachingService
     */
    protected $_cache;

    /**
     * Constructor for the creq service
     */
    function __construct()
    {
        $this->_cache = UNL_Services_CourseApproval::getCachingService();
    }

    /**
     * Get all course data
     * 
     * @return string XML course data
     */
    function getAllCourses()
    {
        return $this->_getData('creq_allcourses', self::URL);
    }

    /**
     * Get the XML for a specific subject area, e.g. CSCE
     * 
     * @param string $subjectarea Subject area/code to retrieve courses for e.g. CSCE
     * 
     * @return string XML data
     */
    function getSubjectArea($subjectarea)
    {
        return $this->_getData('creq_subject_'.$subjectarea, self::URL.'/subject/'.$subjectarea);
    }

    /**
     * Generic data retrieval method which grabs a URL and caches the data
     * 
     * @param string $key A unique key for this piece of data
     * @param string $url The URL to retrieve data from
     * 
     * @return string The data from the URL
     * 
     * @throws Exception
     */
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
