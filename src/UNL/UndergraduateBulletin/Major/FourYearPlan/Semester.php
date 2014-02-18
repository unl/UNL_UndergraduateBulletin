<?php
class UNL_UndergraduateBulletin_Major_FourYearPlan_Semester extends ArrayIterator
{
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

    function __construct($options = array())
    {
        $this->set($options);
        parent::__construct($this->courses);
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    protected function childObjectMap($key)
    {
        switch ($key) {
            case 'courses':
                return 'UNL_UndergraduateBulletin_Major_FourYearPlan_' . ucfirst($key);
        }

        throw new Exception('unknown child object key: ' . $key);
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