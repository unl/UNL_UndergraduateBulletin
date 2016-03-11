<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;
use UNL\UndergraduateBulletin\SubjectArea\SubjectArea;
use UNL\Services\CourseApproval\Search\Search as CourseSearch;

class Search implements
    \Countable,
    CacheableInterface,
    ControllerAwareInterface,
    \JsonSerializable
{
    public $results;

    public $options = [
        'q' => null,
        'offset' => 0,
        'limit'  => 15,
    ];

    protected $controller;

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;
    }

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = 'Course Search';

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
        $page->pagetitle = '<h1 class="wdn-text-hidden">' . $pageTitle . '</h1>';
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
        return ($this->controller instanceof CatalogController ? 'catalog-' : '')
            . 'coursesearch'.serialize($this->options);
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
    }

    public function run()
    {
        $driver = null;

        if (DBSearcher::databaseExists($this->controller)) {
            $driver = new DBSearcher($this->controller);
        }

        $search = new CourseSearch($driver);

        // There is a subject code prefix, only search the subject code
        if (preg_match('/^([A-Z]{3,4})(\s*:\s*.*)?$/i', $this->options['q'], $matches)
            && file_exists($dataDir . '/subjects/' . strtoupper($matches[1]) . '.xml')
        ) {
            $subject = strtoupper($matches[1]);
            $this->options['q'] = $subject;
            $this->results = new SubjectAwareIterator(
                $search->bySubject(
                    $subject,
                    $this->options['offset'],
                    $this->options['limit']
                ),
                $subject
            );

            return;
        }

        // Check to see if the query matches the full description of a subject code
        if ($area = SubjectArea::getByTitle($this->options['q'])) {
            $this->options['q'] = $area->subject .' : ' . $area->title;
            $this->results = new SubjectAwareIterator(
                $search->bySubject(
                    $area->subject,
                    $this->options['offset'],
                    $this->options['limit']
                ),
                $area->subject
            );

            return;
        }

        $this->results = $search->byAny($this->options['q'], $this->options['offset'], $this->options['limit']);

        if (!($this->results instanceof SubjectAwareIterator) && count($this) === 1) {
            foreach ($this->results as $course) {
                $listing = new Listing($course->getRenderListing());
                header('Location: ' . $listing->getURL($this->controller), true, 302);
                exit;
            }
        }
    }

    /**
     * Get the filters used for this search
     *
     * @return Filters
     */
    public function getFilters()
    {
        return new Filters($this->options);
    }


    public function count()
    {
        return count($this->results);
    }

    public function jsonSerialize()
    {
        $courseListings = [];
        foreach ($this->results as $course) {
            $courseListings[] = new Listing($course->getRenderListing());
        }

        return $courseListings;
    }
}
