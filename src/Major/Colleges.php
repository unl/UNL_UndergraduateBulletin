<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\College\Colleges as CollegeCollection;

class Colleges extends \FilterIterator
{
    /**
     * The value from the college quickpoint for this major
     *
     * @var array
     */
    protected $colleges;

    public function __construct($options = array())
    {
        if (!isset($options['colleges'])) {
            throw new Exception('You must pass a list of colleges');
        }
        $this->setColleges($options['colleges']);
        parent::__construct(new CollegeCollection());
    }

    public function setColleges($colleges)
    {
        if (!is_array($colleges)) {
            $colleges = explode(',', $colleges);
        }
        array_walk($colleges, function (&$college) {
            $college = trim($college);
        });
        $this->colleges = $colleges;
    }

    public function getArray()
    {
        return $this->colleges;
    }

    public function accept()
    {
        return $this->relationshipExists($this->current()->getName());
    }

    /**
     * Checks if a relationship exists between this major and the given college
     *
     * @param string $collegeName
     */
    public function relationshipExists($collegeName)
    {
        return in_array($collegeName, $this->colleges);
    }
}
