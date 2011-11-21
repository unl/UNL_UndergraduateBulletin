<?php
class UNL_Services_CourseApproval_CachingService_Null implements UNL_Services_CourseApproval_CachingService
{
    function get($key)
    {
        // Expired cache always.
        return false;
    }
    
    function save($key, $data)
    {
        // Make it appear as though it was saved.
        return true;
    }
}
