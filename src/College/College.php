<?php

namespace UNL\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;
use UNL\UndergraduateBulletin\RoutableInterface;

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
        $page = $controller->getOutputPage();
        $pageTitle = $controller->getOutputController()->escape($this->name);

        $titleContext = 'Undergraduate Bulletin';
        $page->doctitle = sprintf(
            '<title>%s | %s | University of Nebraska-Lincoln</title>',
            $pageTitle,
            $titleContext
        );
        $page->pagetitle = '<h1>' . $pageTitle . '</h1>';
        $page->breadcrumbs->addCrumb($pageTitle);

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
