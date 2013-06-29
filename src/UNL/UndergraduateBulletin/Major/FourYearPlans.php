<?php
class UNL_UndergraduateBulletin_Major_FourYearPlans extends ArrayIterator
{
    public $major;
    
    function __construct($major)
    {
        $plans = array();

        $this->major = $major;

        parent::__construct($plans);
    }

    function current()
    {
        return new UNL_UndergraduateBulletin_FourYearPlan(array('id'=>parent::current()));
    }
}