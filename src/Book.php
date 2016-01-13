<?php
class UNL_UndergraduateBulletin_Book
{
    public $options;
    
    public $policies;
    
    public $colleges;
    
    function __construct($options = array())
    {
        $this->options = $options;
        
        $this->policies = new UNL_UndergraduateBulletin_OtherAreas();
        $this->colleges = new UNL_UndergraduateBulletin_CollegeList();
    }
}
