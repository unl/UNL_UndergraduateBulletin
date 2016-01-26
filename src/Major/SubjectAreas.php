<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\SubjectArea\SubjectArea;

class SubjectAreas extends \ArrayIterator
{
    protected $major;

    public function __construct($major)
    {
        $subjectCodes = [];
        $this->major = $major;

        $mapping = static::getMapping();

        if (isset($mapping[$this->major->title])) {
            $subjectCodes = $mapping[$this->major->title];

            if (!is_array($subjectCodes)) {
                throw new \Exception('Subject codes for '.$major.' are formatted incorrectly in the map file.', 500);
            }
        }

        parent::__construct($subjectCodes);
    }

    public function __get($var)
    {
        if ('major' === $var) {
            return $this->getMajor();
        }
    }

    public function getMajor()
    {
        return $this->major;
    }

    public static function getMapping()
    {
        $mapping = file_get_contents(Controller::getEdition()->getDataDir().'/major_to_subject_code.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new \Exception('Invalid major to subject code matching file.', 500);
        }

        return $mapping;
    }

    public function current()
    {
        return new SubjectArea(['id' => parent::current()]);
    }
}
