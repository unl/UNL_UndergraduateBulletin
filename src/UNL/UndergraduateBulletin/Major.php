<?php
class UNL_UndergraduateBulletin_Major
{
    
    public $title;
    
    public $college;
    
    public $options;
    
    protected $_description;
    
    protected $_subjectareas;
    
    function __construct($options = array())
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;
    }
    
    
    function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->getDescription();
            case 'subjectareas':
                return $this->getSubjectAreas();
        }
        throw new Exception('Unknown member var! '.$var);
    }
    
    function getDescription()
    {
        if (!$this->_description) {
            $this->_description = new UNL_UndergraduateBulletin_Major_Description($this);
        }
        return $this->_description;
    }
    
    function getSubjectAreas()
    {
        if (!$this->_subjectareas) {
            $this->_subjectareas = new UNL_UndergraduateBulletin_Major_SubjectAreas($this);
        }
        return $this->_subjectareas;
    }
    
    function __set($var, $val)
    {
        
    }
    
    static function getByName($name)
    {
        $major = new UNL_UndergraduateBulletin_Major();
        $major->title = $name;
        return $major;
    }
}
?>