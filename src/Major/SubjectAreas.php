<?php
class UNL_UndergraduateBulletin_Major_SubjectAreas extends ArrayIterator
{
    public $major;
    
    function __construct($major)
    {
        $subject_codes = array();

        $this->major = $major;

        $mapping = self::getMapping();

        if (isset($mapping[$this->major->title])) {
            $subject_codes = $mapping[$this->major->title];

            if (!is_array($subject_codes)) {
                throw new Exception('Subject codes for '.$major.' are formatted incorrectly in the map file.', 500);
            }
        }

        parent::__construct($subject_codes);
    }

    public static function getMapping()
    {
        $mapping = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/major_to_subject_code.php.ser');

        if (false === ($mapping = unserialize($mapping))) {
            throw new Exception('Invalid major to subject code matching file.', 500);
        }

        return $mapping;
    }
    
    function current()
    {
        return new UNL_UndergraduateBulletin_SubjectArea(array('id'=>parent::current()));
    }
}
