<?php

namespace UNL\UndergraduateBulletin\Major\LearningOutcome;

use UNL\UndergraduateBulletin\Major\DataTrait;

class Concentration extends \FilterIterator
{
    use DataTrait;

    public function __construct($options = [])
    {
        $this->set($options['id']);
        parent::__construct(new \ArrayIterator($this->data));
    }

    public function accept()
    {
        $key = parent::key();

        if ($key == 'notes') {
            return false;
        }

        $description = parent::current();
        return !empty($description);
    }
}
