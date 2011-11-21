<?php 
interface UNL_Services_CourseApproval_CachingService
{
    function save($key, $data);
    function get($key);
}
