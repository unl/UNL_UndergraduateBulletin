<?php

namespace UNL\UndergraduateBulletin\Major\FourYearPlan;

use UNL\UndergraduateBulletin\Major\DataTrait;

class Concentration extends \ArrayIterator
{
    use DataTrait;

    public function __construct($options = [])
    {
        $this->set($options['id']);
        parent::__construct(isset($this->data['semesters']) ? $this->data['semesters'] : []);
    }

    public function __get($name)
    {
        if ('notes' === $name) {
            return $this->data['notes'];
        }
    }

    public function __isset($name)
    {
        if ('notes' === $name) {
            return isset($this->data['notes']);
        }

        return false;
    }

    public function current()
    {
        return $this->buildSemesterObject(parent::key(), parent::current());
    }

    public function offsetGet($offset)
    {
        return $this->buildSemesterObject($offset, parent::offsetGet($offset));
    }

    protected function buildSemesterObject($semesterNumber, $data)
    {
        $semester = new Semester($data);
        $semester->semesterNumber = $semesterNumber;
        return $semester;
    }
}
