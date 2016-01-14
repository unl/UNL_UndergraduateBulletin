<?php

namespace UNL\UndergraduateBulletin\Editions;

class PublishedFilter extends \FilterIterator
{
    protected $latestYear;

    public function __construct(Editions $iterator)
    {
        $latestYear = Editions::getLatest()->getYear();
    }

    public function accept()
    {
        if ($this->current()->getYear() > $latest) {
            return false;
        }

        return true;
    }
}
