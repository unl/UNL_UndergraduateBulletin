<?php
class UNL_UndergraduateBulletin_College
{
    public $name;

    protected $_description;
    
    function __construct($name)
    {
        $this->name = $name;
    }

    function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->getDescription();
            case 'majors':
                return $this->getDescription()->majors;
        }
        throw new Exception('Unknown member var! '.$var);
    }

    /**
     * Get the description for this college.
     * 
     * @return UNL_UndergraduateBulletin_College_Description
     */
    function getDescription()
    {
        if (!$this->_description) {
            $this->_description = new UNL_UndergraduateBulletin_College_Description($this);
        }
        return $this->_description;
    }
}