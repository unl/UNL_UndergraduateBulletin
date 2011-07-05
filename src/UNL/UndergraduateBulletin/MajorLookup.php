<?php
class UNL_UndergraduateBulletin_MajorLookup extends ArrayIterator
{
    function __construct($options = array())
    {
        $mapping = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/major_lookup.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new Exception('Invalid acad plan to major matching file.', 500);
        }

        parent::__construct($mapping);
    }
}
