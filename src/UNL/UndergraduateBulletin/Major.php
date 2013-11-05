<?php
class UNL_UndergraduateBulletin_Major implements UNL_UndergraduateBulletin_CacheableInterface
{
    
    public $title;
    
    public $options;
    
    /**
     * 
     * @var UNL_UndergraduateBulletin_Major_Description
     */
    protected $_description;
    
    protected $_subjectareas;
    
    function __construct($options = array())
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;
    }
    
    function getCacheKey()
    {
        return 'major'.$this->title.$this->options['view'];
    }
    
    function preRun()
    {
        
    }
    
    function run()
    {
        
    }
    
    function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->getDescription();
            case 'subjectareas':
                return $this->getSubjectAreas();
            case 'colleges':
                return $this->getColleges();
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

    /**
     * Get all course subject areas associated with this major.
     * 
     * @return UNL_UndergraduateBulletin_Major_SubjectAreas
     */
    function getSubjectAreas()
    {
        if (!$this->_subjectareas) {
            $this->_subjectareas = new UNL_UndergraduateBulletin_Major_SubjectAreas($this);
        }
        return $this->_subjectareas;
    }

    /**
     * Get the Four-Year-Plans associated with this major
     *
     * @return UNL_UndergraduateBulletin_Major_FourYearPlans
     */
    public function getFourYearPlans()
    {
        try {
            return new UNL_UndergraduateBulletin_Major_FourYearPlans($this->options);
        } catch (Exception $e) {
            return false;
        }
    }

    function getColleges()
    {
        return $this->getDescription()->colleges;
    }
    
    function __isset($var)
    {
        switch ($var) {
            case 'colleges':
                return isset($this->getDescription()->colleges);
        }
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
    
    function minorAvailable()
    {
        if (isset($this->description->quickpoints['Minor Available'])) {
            if (preg_match('/^Yes/', $this->description->quickpoints['Minor Available'])) {
                return true;
            }
        }
        return false;
    }
    
    function minorOnly()
    {
        if (strpos($this->title, 'Minor') !== false) {
            return true;
        }
        if (isset($this->description->quickpoints['Degree Offered'])
            && $this->description->quickpoints['Degree Offered'] == 'Minor only') {
            return true;
        }
        if (isset($this->description->quickpoints['Minor Only'])) {
            return true;
        }
        return false;
    }
    
    function getURL()
    {
        $url = UNL_UndergraduateBulletin_Controller::getURL();
        $url .= 'major/'.urlencode($this->title);
        return str_replace('%2F', '/', $url);
    }
}
