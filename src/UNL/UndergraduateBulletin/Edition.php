<?php
class UNL_UndergraduateBulletin_Edition
{
    public $year;

    function __construct($options = array())
    {
        if (!isset($options['year'])) {
            throw new Exception('Unknown edition');
        }

        if (!is_dir(UNL_UndergraduateBulletin_Controller::getDataDir().DIRECTORY_SEPARATOR.$options['year'])) {
            throw new Exception('I don\'t know anything about that edition');
        }

        $this->year = $options['year'];
    }

    function getDataDir()
    {
        return UNL_UndergraduateBulletin_Controller::getDataDir().DIRECTORY_SEPARATOR.$this->year;
    }

    function getYear()
    {
        return $this->year;
    }

    function __toString()
    {
        return (string)$this->year;
    }
}