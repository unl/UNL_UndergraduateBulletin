<?php
class UNL_UndergraduateBulletin_Major_FourYearPlan_Courses extends ArrayIterator
{
    public function set($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
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
        }

        throw new Exception('unknown child object key: ' . $key);
    }
}