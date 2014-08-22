<?php
/**
 * The bulletin contains other areas of content which are not majors
 * or colleges. This class represents those areas of content.
 *
 * @author bbieber
 */
class UNL_UndergraduateBulletin_OtherArea implements UNL_UndergraduateBulletin_CacheableInterface
{

    /**
     * The name of the area
     *
     * @var string
     */
    public $name;

    protected $_description;

    public function __construct($options = array())
    {
        $this->name = $options['name'];
    }

    public function getCacheKey()
    {
        return 'otherarea'.$this->name;
    }

    public function run()
    {
    }

    public function preRun($fromCache, Savvy $savvy)
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

    public function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->getDescription();
        }
    }

    /**
     * Get the description for this area of content.
     * 
     * @return UNL_UndergraduateBulletin_OtherArea_Description
     */
    function getDescription()
    {
        if (!$this->_description) {
            $this->_description = new UNL_UndergraduateBulletin_OtherArea_Description($this);
        }
        return $this->_description;
    }

    public function getURL()
    {
        $url = UNL_UndergraduateBulletin_Controller::getURL().'other/'.urlencode($this->name);
        return str_replace('%2F', '/', $url);
    }
}