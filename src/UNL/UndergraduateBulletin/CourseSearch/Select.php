<?php

class UNL_UndergraduateBulletin_CourseSearch_Select
{
    protected $sql;
    
    public function __construct($sql)
    {
        $this->sql = $sql;
    }
    
    public function __toString()
    {
        return $this->sql;
    }
}
