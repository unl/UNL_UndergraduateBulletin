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
        return 'otherarea'.$this->name;
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
