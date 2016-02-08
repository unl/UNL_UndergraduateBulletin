<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;

class Lookup extends \ArrayIterator implements
    \JsonSerializable
{
    public function __construct($options = [])
    {
        $mapping = file_get_contents(Controller::getEdition()->getDataDir().'/major_lookup.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new \Exception('Invalid acad plan to major matching file.', 500);
        }

        parent::__construct($mapping);
    }

    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}
