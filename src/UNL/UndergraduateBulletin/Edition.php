<?php
class UNL_UndergraduateBulletin_Edition
{
    public $year;

    function __construct($options = array())
    {
        if (!isset($options['year'])) {
            throw new Exception('Unknown edition');
        }

        if (!is_dir(UNL_UndergraduateBulletin_Controller::getDataDir().DIRECTORY_SEPARATOR.(int)$options['year'])) {
            throw new Exception('I don\'t know anything about that edition');
        }

        $this->year = $options['year'];
    }

    function getDataDir()
    {
        return UNL_UndergraduateBulletin_Controller::getDataDir().DIRECTORY_SEPARATOR.(int)$this->year;
    }

    function getCourseDataDir()
    {
        return $this->getDataDir().DIRECTORY_SEPARATOR.'creq';
    }

    function getYear()
    {
        return $this->year;
    }

    /**
     * Get the year range
     *
     * @return string
     */
    function getRange()
    {
        return $this->year.'-'.($this->year+1);
    }

    function getURL()
    {
    	return UNL_UndergraduateBulletin_Controller::getURL().$this->getYear().'/';
    }

    function __toString()
    {
        return (string)$this->year;
    }
}