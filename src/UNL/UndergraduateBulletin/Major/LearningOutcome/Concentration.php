<?php
class UNL_UndergraduateBulletin_Major_LearningOutcome_Concentration extends FilterIterator
{
    public function __construct($options = array())
    {
        $this->set($options['id']);
        parent::__construct(new ArrayIterator($this));
    }

    public function accept()
    {
        $description = parent::current();
        return !empty($description);
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
