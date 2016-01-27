<?php

namespace UNL\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;

class College implements
    CacheableInterface,
    ControllerAwareInterface,
    \JsonSerializable
{
    protected $name;

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
        return 'college' . $this->name;
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
            case 'name':
                return $this->getName();
            case 'description':
                return $this->getDescription();
            case 'majors':
                return $this->getMajors();
            case 'abbreviation':
                return $this->getAbbreviation();
        }

        throw new Exception('Unknown member var! '.$var);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAbbreviation()
    {
        return Colleges::getAbbreviation($this->name);
    }

    /**
     * Get the _description for this college.
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

    public function getMajors()
    {
        return new Majors(['college' => $this]);
    }

    public function getURL()
    {
        return Controller::getURL() . 'college/' . urlencode($this->name);
    }

    public function jsonSerialize()
    {
        return [
            'abbreviation' => $this->getAbbreviation(),
            'name' => $this->getName(),
            'uri' => $this->getURL(),
        ];
    }
}
