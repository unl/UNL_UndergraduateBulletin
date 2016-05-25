<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\GraduateController;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\Course\Filters;
use UNL\UndergraduateBulletin\Course\Listing;
use UNL\UndergraduateBulletin\RoutableInterface;
use UNL\Services\CourseApproval\Filter\ExcludeGraduateCourses;
use UNL\Services\CourseApproval\Filter\ExcludeUndergraduateCourses;
use UNL\Services\CourseApproval\SubjectArea\SubjectArea as RealSubjectArea;

class SubjectArea extends RealSubjectArea implements
    ControllerAwareInterface,
    \JsonSerializable,
    RoutableInterface
{
    protected $options;

    protected $controller;

    protected $title;

    public function __construct($options = [])
    {
        $this->options = $options;

        if (isset($options['title'])) {
            $this->title = $options['title'];
        }
        parent::__construct($options['id']);
    }

    public function __get($var)
    {
        if ('title' === $var) {
            return $this->$var;
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get a subject area by full title
     *
     * @param string $title The full title
     *
     * @return SubjectArea
     */
    public static function getByTitle($title)
    {
        $title = trim(strtolower($title));
        $subjectAreas = new SubjectAreas();
        foreach ($subjectAreas as $code => $area) {
            if (strtolower($area->title) == $title) {
                return $area;
            }
        }
        return false;
    }

    public function setController(Controller $controller)
    {
        if (isset($this->options['redirectToSelf']) && true === $this->options['redirectToSelf']) {
            header('Location: ' . $this->getUrl($controller), true, 301);
            exit();
        }

        $page = $controller->getOutputPage();
        $pageTitle = $controller->getOutputController()->escape($this->getSubject()) . ' Courses';

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

    public function getCourses(Controller $controller = null)
    {
        if (!$controller) {
            $controller = $this->controller;
        }

        if (!$this->courses) {
            $courses = parent::getCourses();

            if (!$controller instanceof CatalogController) {
                $courses = new ExcludeGraduateCourses($courses);
            } elseif ($controller instanceof GraduateController) {
                $courses = $this->getGradSortedCourses(new ExcludeUndergraduateCourses($courses));
            }

            $this->courses = $courses;
        }

        return $this->courses;
    }

    protected function getGradSortedCourses($courses)
    {
        $coursesArray = iterator_to_array($courses);
        uasort($coursesArray, function($a, $b) {
            $aListing = $a->getRenderListing();
            $bListing = $b->getRenderListing();

            $aLastGradListing = $aListing->getCourseNumber();
            $bLastGradListing = $bListing->getCourseNumber();

            foreach ($aListing->getListingsFromSubject() as $listing) {
                if ($listing->getCourseNumber() >= 500) {
                    $aLastGradListing = $listing->getCourseNumber();
                }
            }

            foreach ($bListing->getListingsFromSubject() as $listing) {
                if ($listing->getCourseNumber() >= 500) {
                    $bLastGradListing = $listing->getCourseNumber();
                }
            }

            if ($aLastGradListing == $bLastGradListing) {
                return 0;
            }

            return $aLastGradListing < $bLastGradListing ? -1 : 1;
        });

        return new \ArrayIterator($coursesArray);
    }

    protected function compareCourses($a, $b)
    {

    }

    /**
     * Get the filters used for this search
     *
     * @return Filters
     */
    public function getFilters()
    {
        $filters = new Filters();
        $filters->subject = $this->getSubject();
        $filters->groups = $this->groups;
        return $filters;
    }

    public function jsonSerialize()
    {
        $data = [
            'courses' => [],
        ];

        foreach ($this->getCourses() as $course) {
            $data['courses'][] = new Listing($course->getRenderListing());
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

        $path = 'courses/' . $this->getSubject();

        $pathSuffix = '/';
        if ($format && in_array($format, $suffixFormats, true)) {
            $pathSuffix = '.' . $format;
        }

        if ($controller) {
            return $controller::getURL() . $path . $pathSuffix;
        }

        return Controller::getURL() . $path;
    }
}
