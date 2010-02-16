<?php
class UNL_UndergraduateBulletin_Major
{
    public $title;
    
    public $college;
    
    protected $_description;
    
    protected $_subjectareas;
    
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
        $major = new self();
        switch ($name) {
            case 'Geography':
            case 'Advertising':
            case 'SocialScience':
                include dirname(__FILE__).'/../../data/samples/'.$name.'.php';
                return $major;
            case 'Agribusiness':
                $major = new UNL_UndergraduateBulletin_Major();
                $major->title = $name;
                return $major;
                
        }
        throw new Exception('No major by that name.');
    }
}
?>