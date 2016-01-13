<?php
class UNL_UndergraduateBulletin_Developers
{
    public $resources = array('Course', 'CollegeMajors', 'Colleges', 'SubjectArea', 'CourseSearch', 'FourYearPlans');
    
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
        $replacements = array(
        '",'   => "\",\n",
        '{'    => "{\n",
        '}'    => "}\n",
        '['    => "[\n",
        ']'    => "]\n",
        "}\n," => "\n},",
        );
        $json = str_replace(array_keys($replacements), array_values($replacements), $json);
        return $json;
    }
}