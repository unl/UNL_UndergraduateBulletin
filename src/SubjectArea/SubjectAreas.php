<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
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

        $page = $controller->getOutputPage();
        $pageTitle = 'Subject Areas';

        $titleContext = 'Undergraduate Bulletin';
        if ($controller instanceof CatalogController) {
            $titleContext = 'Course Catalog';
            $page->breadcrumbs->addCrumb('Course Catalog', $controller::getURL() . 'courses/');
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
        return new Filter($this);
    }

    public function jsonSerialize()
    {
        $data = [];
        foreach ($this as $id => $area) {
            $data[$id] = [
                // '@id' => $id,
                'href' => Controller::getURL() . 'courses/' . $id . '/',
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