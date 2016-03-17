<?php

namespace UNL\UndergraduateBulletin\Developers;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\OutputController;
use UNL\UndergraduateBulletin\Router;
use UNL\UndergraduateBulletin\Course\DBSearcher;

class Developers implements
    ControllerAwareInterface
{
    protected $controller;

    protected $resources = [
        'SubjectAreas',
        'SubjectArea',
        'Course',
        'CourseSearch',
        'MajorLookup',
        'Majors',
        'Colleges',
        'CollegeMajors',
        'FourYearPlans',
        'Outcomes',
    ];

    protected $resource;

    public $options = [];

    public function __construct($options = array())
    {
        $this->options = $options;

        if (isset($this->options['resource'])) {
            if (in_array($this->options['resource'], $this->resources)) {
                $this->resource = $this->options['resource'];
            }
        }
    }

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = $doctitle = $crumbTitle = 'API';

        $titleContext = 'Undergraduate Bulletin';
        if ($controller instanceof CatalogController) {
            $titleContext = 'Course Catalog';
            $page->breadcrumbs->addCrumb('Course Catalog', $controller::getURL() . 'courses/');

            $this->resources = [
                'SubjectAreas',
                'SubjectArea',
                'Course',
                'CourseSearch',
            ];
        }

        if ($this->resource) {
            $page->addStylesheet('https://cdn.jsdelivr.net/highlight.js/9.2.0/styles/solarized-dark.min.css');
            $page->breadcrumbs->addCrumb($pageTitle, $this->getURL($controller));
            $pageSubTitle = $pageTitle;
            $pageTitle = $this->getResourceObject()->getTitle();
            $doctitle = $pageTitle . ' - ' . $pageSubTitle;
            $crumbTitle = $pageTitle;
            $pageTitle .= ' <span class="wdn-subhead">' . $pageSubTitle . '</span>';
        }

        $page->doctitle = sprintf(
            '<title>%s | %s | University of Nebraska-Lincoln</title>',
            $crumbTitle,
            $titleContext
        );
        $page->pagetitle = '<h1>' . $pageTitle . '</h1>';
        $page->breadcrumbs->addCrumb($crumbTitle);

        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getResources()
    {
        foreach ($this->resources as $resource) {
            $class = __NAMESPACE__ . '\\' . $resource;
            yield $resource => new $class();
        }
    }

    public function getResourceObject($resource = null)
    {
        if (!$this->resource) {
            return null;
        }

        $class = __NAMESPACE__ . '\\' . $this->resource;
        return new $class();
    }

    public static function formatJSON($json)
    {
        $formatter = new \Camspiers\JsonPretty\JsonPretty();
        return $formatter->prettify($json, null, '    ', true);
    }

    public function getURL(Controller $controller = null)
    {
        $path = 'developers';

        if (!$controller) {
            return Controller::getBaseURL() . $path;
        }

        return $controller::getBaseURL() . $path;
    }

    public function getUrlForResource($resource, Controller $controller)
    {
        return $this->getURL($controller) . '?resource=' . $resource;
    }

    public function simulateRequest($uri, Controller $controller)
    {
        $parsedUrl = parse_url($uri);
        $params = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $params);
        }

        $tempRequestURI = $_SERVER['QUERY_STRING'];
        $_SERVER['QUERY_STRING'] = '';
        $controllerOptions = Router::getRoute($parsedUrl['path'], $controller::getBaseURL()) + $params;
        $controllerClass = get_class($controller);
        $simulationController = new $controllerClass($controllerOptions);
        $simulationOutputController = new OutputController();
        $simulationOutputController->setupFromController($simulationController, false);
        $simulationOutputController->addGlobal('course_search_driver', new DBSearcher());
        $_SERVER['QUERY_STRING'] = $tempRequestURI;

        $output = $simulationOutputController->render($simulationController);

        if ($simulationController->options['format'] === 'json') {
            $output = static::formatJSON($output);
        }

        return $output;
    }
}
