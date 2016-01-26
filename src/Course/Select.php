<?php

namespace UNL\UndergraduateBulletin\Course;

class Select
{
    protected $sql;

    public function __construct($sql)
    {
        $this->sql = $sql;
    }

    public function __toString()
    {
        return $this->sql;
    }
}
