<?php
class UNL_UndergraduateBulletin_Major implements 
    UNL_UndergraduateBulletin_CacheableInterface,
    UNL_UndergraduateBulletin_ControllerAwareInterface
{
    
    public $title;
    
    public $options;
    
    /**
     * 
     * @var UNL_UndergraduateBulletin_Major_Description
     */
    protected $_description;
    
    protected $_subjectareas;
    
    protected $controller;
    
    function __construct($options = array())
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;
    }
    
    public function setController(UNL_UndergraduateBulletin_Controller $controller)
    {
        $this->controller = $controller;
        return $this;
    }
    
    public function getController()
    {
        return $this->controller;
    }
    
    function getCacheKey()
    {
        if (!isset($this->options['view'])) {
            // We're not sure what we're rendering here, do not cache
            return false;
        }

        return 'major'.$this->title.$this->options['view'].$this->options['format'];
    }
    
    function preRun($fromCache, Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', $savvy->escape($this->title) . ' | Undergraduate Bulletin | University of Nebraska-Lincoln');
        
        $subhead = '';
        foreach ($this->getColleges() as $college) {
            $subhead .= $college->name.' ';
        }
        $pagetitle = '<h1>';
        if ($subhead) {
            $pagetitle .= '<span class="subhead">' . $savvy->escape($subhead) . '</span> ';
        }
        $pagetitle .= $savvy->escape($this->title) . '</h1>';
        $controller::setReplacementData('pagetitle', $pagetitle);
        
        $controller::setReplacementData('breadcrumbs', <<<EOD
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="{$controller::getURL()}">Undergraduate Bulletin</a></li>
    <li>{$savvy->escape($this->title)}</li>
</ul>
EOD
        );
        
        if ($this->options['view'] == 'plans') {
            $controller::setReplacementData('head', '<link rel="stylesheet" type="text/css" href="' . $controller::getBaseURL() . 'templates/html/css/modules.courses.css" />');
        }
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
        return new UNL_UndergraduateBulletin_Major_FourYearPlans($this->options);
    }

    /**
     * Get the Learning Outcomes associated with this major
     *
     * @return UNL_UndergraduateBulletin_Major_LearningOutcomes
     */
    public function getLearningOutcomes()
    {
        return new UNL_UndergraduateBulletin_Major_LearningOutcomes($this->options);
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

    /**
     * Get major by name
     *
     * @param string $name Major name, e.g. Accounting
     *
     * @return UNL_UndergraduateBulletin_Major
     */
    static function getByName($name)
    {
        $options = array('name' => $name);

        $major = new UNL_UndergraduateBulletin_Major($options);

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
