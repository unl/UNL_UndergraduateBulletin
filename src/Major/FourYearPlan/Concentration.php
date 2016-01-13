<?php
class UNL_UndergraduateBulletin_Major_FourYearPlan_Concentration extends ArrayIterator
{
    public function __construct($options = array())
    {
        $this->set($options['id']);
        parent::__construct($this->semesters);
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
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
        $semester = new UNL_UndergraduateBulletin_Major_FourYearPlan_Semester($data);

        $semester->semesterNumber = $semesterNumber;
        return $semester;
    }
}