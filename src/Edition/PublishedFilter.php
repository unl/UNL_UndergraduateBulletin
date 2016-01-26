<?php

namespace UNL\UndergraduateBulletin\Edition;

class PublishedFilter extends \FilterIterator
{
    protected $latestYear;

    public function __construct(Editions $iterator)
    {
        $this->latestYear = Editions::getLatest()->getYear();
        parent::__construct($iterator);
    }

    public function accept()
    {
        if ($this->current()->getYear() > $this->latestYear) {
            return false;
        }

        return true;
    }
}
