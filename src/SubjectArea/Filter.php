<?php

namespace UNL\UndergraduateBulletin\SubjectArea;

/**
 * Simple filter for subject codes to hide un-used or un-advertised subject areas
 *
 * @author Brett Bieber <brett.bieber@gmail.com>
 */
class Filter extends \FilterIterator
{
    public static $filteredCodes = [];

    public function __construct(SubjectAreas $subjects)
    {
        parent::__construct($subjects);
    }

    public function accept()
    {
        $code = $this->key();
        if (in_array($code, static::$filteredCodes)) {
            return false;
        }
        return true;
    }
}
