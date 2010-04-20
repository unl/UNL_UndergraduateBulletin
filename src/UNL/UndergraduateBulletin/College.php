<?php
class UNL_UndergraduateBulletin_College
{
    public $name;

    protected $_description;
    
    function __construct($options = array())
    {
        $this->name = $options['name'];
    }

    function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->getDescription();
            case 'majors':
                return new UNL_UndergraduateBulletin_College_Majors(array('college'=>$this));
            case 'abbreviation':
                switch($this->name) {
                    case 'Business Administration':
                        return 'CBA';
                    case 'Education & Human Sciences':
                        return  'CEHS';
                    case 'Agricultural Sciences & Natural Resources':
                        return  'CASNR';
                    case 'Fine & Performing Arts':
                        return  'FPA';
                    case 'Architecture':
                        return 'ARCH';
                    case 'Public Affairs & Community Service':
                        return 'PACS';
                    default:
                        throw new Exception('I don\'t know the abbreviation for '.$this->name);
                }
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
    
    function getURL()
    {
        return UNL_UndergraduateBulletin_Controller::getURL().'college/'.urlencode($this->name);
    }
}