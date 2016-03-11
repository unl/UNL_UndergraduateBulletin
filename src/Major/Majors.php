<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;
use UNL\UndergraduateBulletin\EPUB\Utilities;
use UNL\UndergraduateBulletin\SelfIteratingJsonSerializationTrait;

class Majors extends \ArrayIterator implements
    CacheableInterface,
    ControllerAwareInterface,
    \JsonSerializable
{
    use SelfIteratingJsonSerializationTrait;

    protected $controller;

    public $options = [];

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;
        $majors = glob(Controller::getEdition()->getDataDir() . '/majors/*.xhtml');
        return parent::__construct($majors);
    }

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = 'Majors/Areas of Study';
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
        return 'majorlist' . $this->options['format'];
    }

    public function run()
    {
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
    }

    public function current()
    {
        $name = Utilities::getNameByFile(parent::current());
        return new Major(['name' => $name]);
    }
}
