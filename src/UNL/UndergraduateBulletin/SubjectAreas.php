<?php
class UNL_UndergraduateBulletin_SubjectAreas extends ArrayIterator
{
    function __construct()
    {
        parent::__construct(
            file(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/subject_codes.csv')
        );
    }
}