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
        
        if (isset(parent::current()->college)
            && parent::current()->college->name == $this->college->name) {
            return true;
        }

        return false;
    }
}