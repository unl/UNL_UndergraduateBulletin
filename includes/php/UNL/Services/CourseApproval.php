<?php
class UNL_Services_CourseApproval
{
    /**
     * The caching service used.
     * 
     * @var UNL_Services_CourseApproval_CachingService
     */
    protected static $_cache;
    
    /**
     * The XCRI service used.
     * 
     * @var UNL_Services_CourseApproval_XCRIService
     */
    protected static $_xcri;
    
    /**
     * Get the static caching service
     * 
     * @return UNL_Services_CourseApproval_CachingService
     */
    public static function getCachingService()
    {
        if (!isset(self::$_cache)) {
            try {
                self::setCachingService(new UNL_Services_CourseApproval_CachingService_CacheLite());
            } catch(Exception $e) {
                self::setCachingService(new UNL_Services_CourseApproval_CachingService_Null());
            }
        }
        
        return self::$_cache;
    }
    
    /**
     * Set the static caching service
     * 
     * @param UNL_Services_CourseApproval_CachingService $service The caching service to use
     * 
     * @return UNL_Services_CourseApproval_CachingService
     */
    public static function setCachingService(UNL_Services_CourseApproval_CachingService $service)
    {
        self::$_cache = $service;
        
        return self::$_cache;
    }
    
    /**
     * Gets the XCRI service we're subscribed to.
     * 
     * @return UNL_Services_CourseApproval_XCRIService
     */
    public static function getXCRIService()
    {
        if (!isset(self::$_xcri)) {
            self::setXCRIService(new UNL_Services_CourseApproval_XCRIService_creq());
        }
        
        return self::$_xcri;
    }
    
    /**
     * Set the static XCRI service
     * 
     * @param UNL_Services_CourseApproval_XCRIService $xcri The XCRI service object
     * 
     * @return UNL_Services_CourseApproval_XCRIService
     */
    public static function setXCRIService(UNL_Services_CourseApproval_XCRIService $xcri)
    {
        self::$_xcri = $xcri;
        return self::$_xcri;
    }
}
