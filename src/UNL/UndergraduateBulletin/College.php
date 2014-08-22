<?php
class UNL_UndergraduateBulletin_College implements
    UNL_UndergraduateBulletin_CacheableInterface,
    UNL_UndergraduateBulletin_ControllerAwareInterface
{
    public $name;

    protected $_description;
    
    protected $controller;
    
    function __construct($options = array())
    {
        $this->name = $options['name'];
    }
    
    public function setController(UNL_UndergraduateBulletin_Controller $controller) {
        $this->controller = $controller;
        return $this;
    }

    
    public function getController() {
        return $this->controller;
    }


    function getCacheKey()
    {
        return 'college'.$this->name;
    }

    function run()
    {
        
    }

    function preRun($fromCache, Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', $savvy->escape($this->name) . ' | Undergraduate Bulletin | University of Nebraska-Lincoln');
        
        $pagetitle = '<h1>' . $savvy->escape($this->name) . '</h1>';
        $controller::setReplacementData('pagetitle', $pagetitle);
        
        $controller::setReplacementData('breadcrumbs', <<<EOD
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="{$controller::getURL()}">Undergraduate Bulletin</a></li>
    <li>{$savvy->escape($this->name)}</li>
</ul>
EOD
        );
    }

    function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->getDescription();
            case 'majors':
                return new UNL_UndergraduateBulletin_College_Majors(array('college' => $this));
            case 'abbreviation':
                return UNL_UndergraduateBulletin_CollegeList::getAbbreviation($this->name);
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