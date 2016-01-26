<?php

namespace UNL\UndergraduateBulletin\Major\FourYearPlan;

use UNL\UndergraduateBulletin\Major\DataTrait;

class Semester extends \ArrayIterator
{
    use DataTrait;

    /**
     * Integer of the semester number
     * Typically this will be 1-8
     * 11 = Summer after first year
     * 12 = Summer after second year
     * 13 = Summer after third year
     *
     * @var int
     */
    public $semesterNumber;

    public function __construct($options = [])
    {
        $this->set($options);
        parent::__construct($this->data['courses']);
    }

    /**
     * Check if the semester is a summer semester or not
     *
     * @return boolean
     */
    public function isSummerSemester()
    {
        if ($this->semesterNumber > 8) {
            return true;
        }

        return false;
    }
}
