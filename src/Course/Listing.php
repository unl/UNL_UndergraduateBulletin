<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\RoutableInterface;
use UNL\Services\CourseApproval\Course\Course;
use UNL\Services\CourseApproval\Course\Listing as CreqListing;

class Listing implements
    ControllerAwareInterface,
    \JsonSerializable,
    RoutableInterface
{
    protected static $aceDescriptions = [
        1 => 'Writing',
        2 => 'Communication Competence',
        3 => 'Math/Stat/Reasoning',
        4 => 'Science',
        5 => 'Humanities',
        6 => 'Social Science',
        7 => 'Arts',
        8 => 'Civics/Ethics/Stewardship',
        9 => 'Global/Diversity',
        10 => 'Integrated Product',
    ];

    protected $controller;

    /**
     * @var CreqListing
     */
    protected $internal;

    public static function getACEDescription($ace)
    {
        if (!isset(static::$aceDescriptions[$ace])) {
            return '';
        }

        return static::$aceDescriptions[$ace];
    }

    public function __construct($options = [])
    {
        $listing = $options;
        if (!$listing instanceof CreqListing) {
            $listing = CreqListing::createFromSubjectAndNumber($options['subjectArea'], $options['courseNumber']);
        }

        $this->internal = $listing;
        $listing->getCourse()->setRenderListing($listing);
    }

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = $controller->getOutputController()->escape($this->getTitle());

        $titleContext = 'Undergraduate Bulletin';
        if ($controller instanceof CatalogController) {
            $titleContext = 'Course Catalog';
            $page->breadcrumbs->addCrumb('Course Catalog', $controller::getURL() . 'courses/');
        }

        $permalink = $controller->getOutputController()->escape($this->getURL());

        $page->head .= '<link rel="alternate" type="text/xml" href="'.$permalink.'.xml" />
            <link rel="alternate" type="application/json" href="'.$permalink.'.json" />
            <link rel="alternate" type="text/html" href="'.$permalink.'.partial" />';

        $page->doctitle = sprintf(
            '<title>%s | %s | University of Nebraska-Lincoln</title>',
            $pageTitle,
            $titleContext
        );
        $page->pagetitle = '<h1 class="hidden">' . $pageTitle . '</h1>';
        $page->breadcrumbs->addCrumb($pageTitle);

        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getCourse()
    {
        return $this->internal->getCourse();
    }

    public function getSubject()
    {
        return $this->internal->getSubject();
    }

    public function getCourseNumber()
    {
        return $this->internal->getCourseNumber();
    }

    public function getURL(Controller $controller = null)
    {
        $suffixFormats = [
            'json',
            'xml',
            'partial',
        ];
        $path = 'courses/' . $this->getSubject() . '/' . $this->getCourseNumber();

        if ($controller) {
            $format = isset($controller->options['format']) ? $controller->options['format'] : false;
            $pathSuffix = '';

            if ($format && in_array($format, $suffixFormats, true)) {
                $pathSuffix = '.' . $format;
            }

            return $controller::getURL() . $path . $pathSuffix;
        }

        return Controller::getURL() . $path;
    }

    public function getTitle()
    {
        return $this->getSubject() . ' ' . $this->getListingNumbers() . ': ' . $this->getCourseTitle();
    }

    public function getCourseTitle()
    {
        return $this->internal->getCourse()->title;
    }

    public function getCourseNumberCssClass()
    {
        return 'l' . count($this->internal->getListingsFromSubject());
    }

    public function getCssClass()
    {
        $course = $this->internal->getCourse();
        $classes = array('course');

        $groups = $this->getCourseGroups();

        foreach ($groups as $group) {
            $classes[] = 'grp_' . md5($group);
        }

        foreach ($course->getActivities() as $type => $activity) {
            $classes[] = $type;
        }
        unset($activity);

        if ($course->getACEOutcomes()) {
            $classes[] = 'ace';
        }

        foreach ($course->getACEOutcomes() as $outcome) {
            $classes[] = 'ace_' . $outcome;
        }

        return implode(' ', $classes);
    }

    public function getListingNumbers()
    {
        $listings = array();

        foreach ($this->internal->getListingsFromSubject() as $listing) {
            $listings[] = $listing->getCourseNumber();
        }

        sort($listings);
        return implode('/', $listings);
    }

    public function getCourseGroups()
    {
        $groups = array();
        foreach ($this->internal->getListingsFromSubject() as $listing) {
            if ($listing->hasGroups()) {
                foreach ($listing->getGroups() as $group) {
                    $groups[] = (string) $group;
                }
            }
        }

        return array_unique($groups);
    }

    public function getCrosslistings()
    {
        $listings = $this->internal->getCrosslistingsBySubject();
        $subjectStrings = array();

        foreach ($listings as $subject => $subjectListings) {
            $listingNumbers = array();

            foreach ($subjectListings as $listing) {
                $listingNumbers[] = $listing->getCourseNumber();
            }

            $subjectStrings[] = $subject . ' ' . implode('/', $listingNumbers);
        }

        return implode(', ', $subjectStrings);
    }

    public function getSubsequentCourses($searcher)
    {
        $courses = $this->internal->getSubsequentCourses($searcher);
        return $courses;
    }

    public function jsonSerialize()
    {
        $course = $this->getCourse();
        $data = [
            'title' => $course->title,
            'courseCodes' => [],
            'gradingType' => $course->gradingType,
            'dfRemoval' => $course->dfRemoval,
            'effectiveSemester' => $course->effectiveSemester,
            'prerequisite' => $course->prerequisite,
            'description' => $course->description,
            'campuses' => $course->getCampuses(),
            'deliveryMethods' => $course->getDeliveryMethods(),
            'termsOffered' => $course->getTermsOffered(),
            'activities' => [],
            'credits' => [],
        ];

        if ($aceOutcomes = $course->getACEOutcomes()) {
            $data['aceOutcomes'] = $aceOutcomes;
        }

        foreach ($course->getCodes() as $listing) {
            $data['courseCodes'][] = [
                '@type' => $listing->getType(),
                'subject' => (string)$listing->subjectArea,
                'courseNumber' => $listing->courseNumber
            ];
        }

        foreach ($course->getActivities() as $activity) {
            $data['activities'][] = [
                'type' => (string) $activity->type,
                'hours' => (int) $activity->hours,
            ];
        }

        foreach ($course->getCredits() as $credit) {
            $data['credits'][] = [
                '@type' => (string) $credit['type'],
                '' => (int) $credit,

            ];
        }

        return $data;
    }
}
