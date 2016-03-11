<?php

namespace UNL\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\SelfIteratingJsonSerializationTrait;
use UNL\UndergraduateBulletin\Major\Majors as MajorCollection;

class Majors extends \FilterIterator implements
    ControllerAwareInterface,
    \JsonSerializable
{
    use SelfIteratingJsonSerializationTrait;

    /**
     * The college
     *
     * @var College
     */
    protected $college;

    protected $controller;

    public function __construct($options = [])
    {
        if (!isset($options['college'])) {
            $options['college'] = new College($options);
        }

        $this->college = $options['college'];

        parent::__construct(new MajorCollection());
    }

    public function accept()
    {
        return $this->current()->getColleges()->relationshipExists($this->college->name);
    }

    public function __get($var)
    {
        if ($var == 'college') {
            return $this->getCollege();
        }

        throw new \Exception("There's no var with name: $var");
    }

    public function getCollege()
    {
        return $this->college;
    }

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = $controller->getOutputController()->escape($this->getCollege()->name) . ' Majors';

        $titleContext = 'Undergraduate Bulletin';
        $page->doctitle = sprintf(
            '<title>%s | %s | University of Nebraska-Lincoln</title>',
            $pageTitle,
            $titleContext
        );
        $page->pagetitle = '<h1>' . $pageTitle . '</h1>';
        // $page->breadcrumbs->addCrumb($this->getCollege()->name, $this->getCollege()->getURL());
        $page->breadcrumbs->addCrumb($pageTitle);

        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }
}
