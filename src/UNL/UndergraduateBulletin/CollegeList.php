<?php
class UNL_UndergraduateBulletin_CollegeList extends FilterIterator
{
    public $options = array('name'=>false);

    static $colleges = array();

    function __construct($options = array())
    {
        parent::__construct(new ArrayIterator(self::$colleges));
    }

    function accept()
    {
        return true;
    }
    
    public static function getAbbreviation($name)
    {
        if (!in_array($name, self::$colleges)) {
            throw new Exception('I don\'t know the abbreviation for '.$name.'. It needs to be added to the list.', 500);
        }
        $reversed = array_flip(self::$colleges);
        return $reversed[$name];
    }

    function current()
    {
        return new UNL_UndergraduateBulletin_College(array('name'=>parent::current()));
    }
}