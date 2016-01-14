<?php

namespace UNL\UndergraduateBulletin;

class Book
{
    public $options;

    public $policies;

    public $colleges;

    public function __construct($options = [])
    {
        $this->options = $options;
        $this->policies = new OtherArea\OtherAreas();
        $this->colleges = new College\Colleges();
    }
}
