<?php

namespace UNL\UndergraduateBulletin;

class BulletinRules implements
    ControllerAwareInterface
{
    protected $controller;

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = 'Rules';

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
