<?php
class UNL_UndergraduateBulletin_College
{
    public $name;
    
    function __construct($name)
    {
        $this->name = $name;
        
        $this->description = file_get_contents(dirname(__FILE__).'/../../data/colleges/CEHS.xhtml');

    }
}