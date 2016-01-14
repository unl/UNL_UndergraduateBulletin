<?php

namespace UNL\UndergraduateBulletin\Edition;

use UNL\UndergraduateBulletin\Controller;

class Edition
{
    protected $year;

    public function __construct($options = [])
    {
        if (!isset($options['year'])) {
            throw new \Exception('Unknown edition');
        }

        $this->year = $options['year'];

        if (!is_dir($this->getDataDir())) {
            throw new \Exception('I don\'t know anything about that edition');
        }
    }

    /**
     * Get a specific edition by year
     *
     * @param int $year
     *
     * @return self
     */
    public static function getByYear($year)
    {
        return new self(['year' => (int) $year]);
    }

    /**
     * Return a unique ID for this specific edition.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return $this->getYear() . __CLASS__;
    }

    /**
     * Get the data directory where this edition stores its data
     *
     * @return string
     */
    public function getDataDir()
    {
        return Controller::getDataDir() . DIRECTORY_SEPARATOR . (int) $this->year;
    }

    public function getCourseDataDir()
    {
        return $this->getDataDir() . DIRECTORY_SEPARATOR . 'creq';
    }

    public function getYear()
    {
        return $this->year;
    }

    /**
     * Get the year range
     *
     * @return string
     */
    public function getRange()
    {
        return $this->year . '-' . ($this->year + 1);
    }

    public function loadConfig()
    {
        $configFile = $this->getDataDir() . '/edition.config.inc.php';

        if (file_exists($configFile)) {
            require $configFile;
        }

        return true;
    }

    public function getURL()
    {
        return Controller::getBaseURL() . $this->getYear() . '/';
    }

    public function __toString()
    {
        return (string) $this->year;
    }
}
