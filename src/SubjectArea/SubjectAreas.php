<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\GraduateController;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;

class SubjectAreas extends \ArrayIterator implements
    CacheableInterface,
    ControllerAwareInterface,
    \JsonSerializable
{
    protected $controller;

    /**
     * Returns an array with subject code keys and title values
     *
     * @throws Exception
     * @return array
     */
    public static function getMap($edition = null)
    {
        if (!$edition) {
            $edition = Controller::getEdition();
        }

        $mapping = file_get_contents($edition->getCourseDataDir() . '/subject_codes.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new \Exception('Invalid major to subject code matching file.', 500);
        }

        return $mapping;
    }

    public function __construct($options = [])
    {
        $this->options = $options;

        parent::__construct(self::getMap());
    }

    public function setController(Controller $controller)
    {
        if (isset($this->options['redirectToSelf']) && true === $this->options['redirectToSelf']) {
            header('Location: ' . $this->getUrl($controller), true, 301);
            exit();
        }

        // the subject map may be different from the controller
        parent::__construct(self::getMap($controller::getEdition()));

        $page = $controller->getOutputPage();
        $pageTitle = 'Subject Areas';

        $titleContext = 'Undergraduate Bulletin';
        if ($controller instanceof CatalogController) {
            $titleContext = 'Course Catalog';

            if ($controller instanceof GraduateController) {
                $titleContext = 'Graduate ' . $titleContext;
            }

            $page->breadcrumbs->addCrumb($titleContext, $controller::getURL() . 'courses/');
        }

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
        return 'subjectareas'.$this->options['format'];
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
    }

    public function run()
    {
    }

    public function current()
    {
        $options = array(
            'id' => $this->key(),
            'title' => parent::current(),
        );

        $area = new SubjectArea($options);
        return $area;
    }

    public function getFiltered()
    {
        if ($this->controller instanceof GraduateController) {
            return new FilterWithCourses($this, $this->controller);
        }

        return new Filter($this);
    }

    public function jsonSerialize()
    {
        $url = Controller::getURL();
        $controller = $this->controller;

        if ($controller) {
            $url = $controller::getURL();
        }

        $data = [];
        foreach ($this as $id => $area) {
            $data[$id] = [
                // '@id' => $id,
                'href' => $url . 'courses/' . $id . '/',
                'title' => $area->title,
            ];
        }

        return $data;
    }

    public function getUrl(Controller $controller = null)
    {
        $suffixFormats = [
            'json',
            'xml',
            'partial',
        ];
        $format = isset($this->options['format']) ? $this->options['format'] : false;
        $path = 'courses';
        $pathSuffix = '/';

        if ($format && in_array($format, $suffixFormats, true)) {
            $pathSuffix = '.' . $format;
        }

        if ($controller) {
            return $controller::getURL() . $path . $pathSuffix;
        }

        return Controller::getURL() . $path . $pathSuffix;
    }
}
