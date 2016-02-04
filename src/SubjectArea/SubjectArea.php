<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Course\Filters;
use UNL\UndergraduateBulletin\Course\Listing;
use UNL\Services\CourseApproval\Filter\ExcludeGraduateCourses;
use UNL\Services\CourseApproval\SubjectArea\SubjectArea as RealSubjectArea;

class SubjectArea extends RealSubjectArea implements
    \jsonSerializable
{
    public $title;

    public function __construct($options = [])
    {
        if (isset($options['title'])) {
            $this->title = $options['title'];
        }
        parent::__construct($options['id']);
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

    public function getCourses()
    {
        if (!$this->courses) {
            $this->courses = new ExcludeGraduateCourses(parent::getCourses());
        }

        return $this->courses;
    }

    /**
     * Get the filters used for this search
     *
     * @return Filters
     */
    public function getFilters()
    {
        $filters = new Filters();
        $filters->groups = $this->groups;
        return $filters;
    }

    public function jsonSerialize()
    {
        $data = [
            'courses' => [],
        ];

        foreach ($this->courses as $course) {
            $data['courses'][] = new Listing($course->getRenderListing());
        }

        return $data;
    }
}
