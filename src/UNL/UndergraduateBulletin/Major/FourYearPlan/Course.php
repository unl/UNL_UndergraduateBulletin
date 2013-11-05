<?php
class UNL_UndergraduateBulletin_Major_FourYearPlan_Course
{
    public function __construct($options = array())
    {
        $this->set($options);
        //var_dump($this);
        //exit();
        parent::__construct($this->data);
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                var_dump($value);
                exit();
                $sub_class = $this->childObjectMap($key);
                $sub = new $sub_class();
                $sub->set($value);
                $value = $sub;
            }
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