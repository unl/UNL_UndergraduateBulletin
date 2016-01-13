<?php
/**
 * Simple filter for subject codes to hide un-used or un-advertised subject areas
 * 
 * @author Brett Bieber <brett.bieber@gmail.com>
 */
class UNL_UndergraduateBulletin_SubjectAreas_Filter extends FilterIterator
{
    public static $filtered_codes = array();

    function __construct(UNL_UndergraduateBulletin_SubjectAreas $subjects)
    {
        parent::__construct($subjects);
    }

    function accept()
    {
        $code = $this->key();
        if (in_array($code, self::$filtered_codes)) {
            return false;
        }
        return true;
    }
}