<?php
class UNL_UndergraduateBulletin_ClassToTemplateMapper extends Savvy_ClassToTemplateMapper
{
    function map($class)
    {
        $class = str_replace(array('UNL_UndergraduateBulletin_', 'UNL_Services_CourseApproval_'), '', $class);
        return parent::map($class);
    }
}