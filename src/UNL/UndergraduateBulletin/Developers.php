<?php
class UNL_UndergraduateBulletin_Developers
{
    public $resources = array('Course');
    
    public $resource;
    
    public $options = array();
    
    function __construct($options = array())
    {
        $this->options  = $options;
        $this->resource = $this->resources[0];
        
        if (isset($this->options['resource']) ) {
            if (in_array($this->options['resource'], $this->resources)) {
                $this->resource = $this->options['resource'];
            }
        }
    }
    
    static function formatJSON($json)
    {
        $json = str_replace("\",", "\",".PHP_EOL, $json);
        $json = str_replace("{","{".PHP_EOL, $json);
        $json = str_replace("}","}".PHP_EOL, $json);
        $json = str_replace("[","[".PHP_EOL, $json);
        $json = str_replace("]","]".PHP_EOL, $json);
        $json = str_replace("}".PHP_EOL.",",PHP_EOL."},".PHP_EOL, $json);
        return $json;
    }
}