<?php

class UNL_UndergraduateBulletin_SubjectAwareCourseIterator extends IteratorIterator implements Countable
{
    protected $subject;
    
    public function __construct(Traversable $iterator, $subject)
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
        
        if (!$course instanceof UNL_Services_CourseApproval_Course) {
            throw UnexpectedValueException('The iterator expects only instances of UNL_Services_CourseApproval_Course');
        }
        
        $course->subject = $this->subject;
        
        return $course;
    }
    
    public function count()
    {
        return count($this->getInnerIterator());
    }
}
