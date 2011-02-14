<?php
class UNL_UndergraduateBulletin_Editions_PublishedFilter extends FilterIterator
{
    function __construct(Iterator $iterator)
    {
        parent::__construct($iterator);
    }

    function accept()
    {
        static $latest = false;
        if (!$latest) {
            $latest = UNL_UndergraduateBulletin_Editions::getLatest()->year;
        }

        if (parent::current()->year > $latest) {
            return false;
        }

        return true;
    }
}