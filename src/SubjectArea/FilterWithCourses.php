<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Controller;

class FilterWithCourses extends \FilterIterator
{
    protected $controller;

    public function __construct(SubjectAreas $subjects, Controller $controller)
    {
        $this->controller = $controller;
        parent::__construct($subjects);
    }

    public function accept()
    {
        $courses = $this->current()->getCourses($this->controller);
        return iterator_count($courses) > 0;
    }
}
