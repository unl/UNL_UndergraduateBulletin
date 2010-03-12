<?php
class UNL_UndergraduateBulletin_SubjectArea extends UNL_Services_CourseApproval_SubjectArea
{
    function __construct($options = array())
    {
        parent::__construct($options['id']);
    }
}