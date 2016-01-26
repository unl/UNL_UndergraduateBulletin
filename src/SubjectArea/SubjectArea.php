<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Course\Filters;
use UNL\Services\CourseApproval\Filter\ExcludeGraduateCourses;
use UNL\Services\CourseApproval\SubjectArea\SubjectArea as RealSubjectArea;

class SubjectArea extends RealSubjectArea
{
    public $title;

    public function __construct($options = [])
    {
        if (isset($options['title'])) {
            $this->title = $options['title'];
        }
        parent::__construct($options['id']);

        $this->courses = new ExcludeGraduateCourses($this->courses);
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
}
