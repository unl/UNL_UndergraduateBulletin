<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\Services\CourseApproval\Course\Course;

class SubjectAwareIterator extends \IteratorIterator implements
    \Countable
{
    protected $subject;

    public function __construct(\Traversable $iterator, $subject)
    {
        if (empty($subject)) {
            throw InvalidArgumentException('Missing subject to use for course iterator rendering');
        }

        $this->subject = $subject;
        parent::__construct($iterator);
    }

    public function current()
    {
        $course = parent::current();

        if (!$course instanceof Course) {
            throw UnexpectedValueException('The iterator expects only instances of ' . Course::class);
        }

        $course->setSubject($this->subject);
        return $course;
    }

    public function count()
    {
        return count($this->getInnerIterator());
    }
}
