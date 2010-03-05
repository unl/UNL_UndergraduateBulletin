<?php
class UNL_UndergraduateBulletin_Major
{
    protected static $major_file_names = array('CRIM and CRIM JUS'=>'Criminology and Criminal Justice');
    
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
    
    static function getNameByFile($filename)
    {
        
        $filename = str_replace(array(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/', '.epub'), '', $filename);
        
        if (isset(UNL_UndergraduateBulletin_Major::$major_file_names[$filename])) {
            return UNL_UndergraduateBulletin_Major::$major_file_names[$filename];
        }
        return $filename;
    }
    
    static function getFileByName($name)
    {
        if ($new = array_search($name, UNL_UndergraduateBulletin_Major::$major_file_names)) {
            $name = $new;
        }
        return UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/'.$name.'.epub';
    }
    
    static function getByName($name)
    {
        $major = new UNL_UndergraduateBulletin_Major();
        $major->title = $name;
        return $major;
    }
}
?>