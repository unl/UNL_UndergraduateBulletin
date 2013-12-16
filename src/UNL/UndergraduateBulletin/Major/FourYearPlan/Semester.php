<?php
class UNL_UndergraduateBulletin_Major_FourYearPlan_Semester extends ArrayIterator
{
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
}