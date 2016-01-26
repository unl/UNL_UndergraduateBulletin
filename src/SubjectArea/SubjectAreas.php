<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;

class SubjectAreas extends \ArrayIterator implements CacheableInterface
{
    /**
     * Returns an array with subject code keys and title values
     *
     * @throws Exception
     * @return array
     */
    public static function getMap($edition = null)
    {
        if (!$edition) {
            $edition = Controller::getEdition();
        }

        $mapping = file_get_contents($edition->getCourseDataDir() . '/subject_codes.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new Exception('Invalid major to subject code matching file.', 500);
        }

        return $mapping;
    }

    public function __construct($options = array())
    {
        $this->options = $options;

        parent::__construct(self::getMap());
    }

    public function getCacheKey()
    {
        return 'subjectareas'.$this->options['format'];
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
    }

    public function run()
    {
    }

    public function current()
    {
        $options = array(
            'id' => $this->key(),
            'title' => parent::current(),
        );

        $area = new SubjectArea($options);
        return $area;
    }
}
