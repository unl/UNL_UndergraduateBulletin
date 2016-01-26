<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\UndergraduateBulletin\Controller;
use UNL\Services\CourseApproval\Course\Course;
use UNL\Services\CourseApproval\Course\Listing as CreqListing;

class Listing
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

    public function getURL()
    {
        return Controller::getURL() . 'courses/' . $this->getSubject() . '/' . $this->getCourseNumber();
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
}
