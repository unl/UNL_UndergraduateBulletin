<?php
class UNL_UndergraduateBulletin_College_Majors extends FilterIterator
{
    protected $college;

    function __construct($options = array())
    {
        $this->college = $options['college'];
        parent::__construct(new UNL_UndergraduateBulletin_MajorList);
    }

    function accept()
    {
        return $this->current()->colleges->relationshipExists($this->college->name);
    }
}