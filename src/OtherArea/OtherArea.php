<?php

namespace UNL\UndergraduateBulletin\OtherArea;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;

/**
 * The bulletin contains other areas of content which are not majors
 * or colleges. This class represents those areas of content.
 *
 * @author bbieber
 */
class OtherArea implements
    CacheableInterface,
    ControllerAwareInterface
{

    /**
     * The name of the area
     *
     * @var string
     */
    public $name;

    protected $description;

    protected $controller;

    public function __construct($options = [])
    {
        $this->name = $options['name'];
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getCacheKey()
    {
        return 'otherarea'.$this->name;
    }

    public function run()
    {
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', $savvy->escape($this->name)
            . ' | Undergraduate Bulletin | University of Nebraska-Lincoln');

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
     * @return Description
     */
    public function getDescription()
    {
        if (!$this->description) {
            $this->description = new Description($this);
        }
        return $this->description;
    }

    public function getURL()
    {
        $url = Controller::getURL().'other/'.urlencode($this->name);
        return str_replace('%2F', '/', $url);
    }
}
