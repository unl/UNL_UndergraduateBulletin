<?php
class UNL_UndergraduateBulletin_College
{
    public $name;
    
    function __construct($name)
    {
        $this->name = $name;
        
        $this->file = dirname(__FILE__).'/../../data/colleges/CEHS.xhtml';
        // read the .epub file?
    }
}