<?php

namespace UNL\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\SelfIteratingJsonSerializationTrait;

class Colleges extends \ArrayIterator implements
    ControllerAwareInterface,
    \JsonSerializable
{
    use SelfIteratingJsonSerializationTrait;

    protected $controller;

    public $options = ['name' => false];

    public static $colleges = [];

    public function __construct($options = [])
    {
        parent::__construct(static::$colleges);
    }

    public static function getAbbreviation($name)
    {
        $reversed = array_flip(static::$colleges);

        if (!isset($reversed[$name])) {
            throw new \Exception('I don\'t know the abbreviation for '
                . $name . '. It needs to be added to the list.', 500);
        }

        return $reversed[$name];
    }

    public function current()
    {
        return new College(['name' => parent::current()]);
    }

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = 'Colleges';

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
}
