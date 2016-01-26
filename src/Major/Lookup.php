<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;

class Lookup extends \ArrayIterator
{
    public function __construct($options = array())
    {
        $mapping = file_get_contents(Controller::getEdition()->getDataDir().'/major_lookup.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new \Exception('Invalid acad plan to major matching file.', 500);
        }

        parent::__construct($mapping);
    }
}
