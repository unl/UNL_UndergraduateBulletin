<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;
use UNL\UndergraduateBulletin\SubjectArea\SubjectArea;
use UNL\Services\CourseApproval\Search\Search as CourseSearch;

class Search implements
    \Countable,
    CacheableInterface,
    ControllerAwareInterface
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
        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getCacheKey()
    {
        return 'coursesearch'.serialize($this->options);
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', 'Course Search'
            . ' | Undergraduate Bulletin | University of Nebraska-Lincoln');

        $pagetitle = '<h1>Course Search</h1>';
        $controller::setReplacementData('pagetitle', $pagetitle);

        $controller::setReplacementData('breadcrumbs', <<<EOD
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="{$controller::getURL()}">Undergraduate Bulletin</a></li>
    <li><a href="{$controller::getURL()}courses/">Courses</a></li>
    <li>Search</li>
</ul>
EOD
        );
    }

    public function run()
    {
        $driver = null;
        $dataDir = Controller::getEdition()->getCourseDataDir();

        if (file_exists($dataDir . '/courses.sqlite')) {
            $driver = new DBSearcher();
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
}
