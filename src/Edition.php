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

    /**
     * Get a specific edition by year
     *
     * @param int $year
     *
     * @return UNL_UndergraduateBulletin_Edition
     */
    public static function getByYear($year)
    {
        return new self(array('year'=>(int)$year));
    }

    /**
     * Return a unique ID for this specific edition.
     *
     * @return string
     */
    function getCacheKey()
    {
        return $this->getYear().get_class($this);
    }

    /**
     * Get the data directory where this edition stores its data
     *
     * @return string
     */
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

    function loadConfig()
    {
        if (file_exists($this->getDataDir().'/edition.config.inc.php')) {
            require $this->getDataDir().'/edition.config.inc.php';
        }
        return true;
    }

    function getURL()
    {
    	return UNL_UndergraduateBulletin_Controller::getBaseURL().$this->getYear().'/';
    }

    function __toString()
    {
        return (string)$this->year;
    }
}