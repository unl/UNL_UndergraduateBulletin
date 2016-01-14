<?php

namespace UNL\UndergraduateBulletin\College;

class Colleges extends \ArrayIterator
{
    public $options = ['name' => false];

    public static $colleges = [];

    public function __construct($options = [])
    {
        parent::__construct(static::$colleges);
    }

    public static function getAbbreviation($name)
    {
        $reversed = array_flip(static::$colleges);

        if (!isset($reversed[$name])) {
            throw new \Exception('I don\'t know the abbreviation for '.$name.'. It needs to be added to the list.', 500);
        }

        return $reversed[$name];
    }

    public function current()
    {
        return new College(['name' => parent::current()]);
    }
}
