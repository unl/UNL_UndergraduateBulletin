<?php
class UNL_UndergraduateBulletin_College_Majors extends FilterIterator
{
	/**
	 * The college
	 *
	 * @var UNL_UndergraduateBulletin_College
	 */
    protected $_college;

    function __construct($options = array())
    {
    	if (!isset($options['college'])) {
    		$options['college'] = new UNL_UndergraduateBulletin_College($options);
    	}
        $this->_college = $options['college'];
        parent::__construct(new UNL_UndergraduateBulletin_MajorList);
    }

    function accept()
    {
        return $this->current()->colleges->relationshipExists($this->_college->name);
    }

    function __get($var)
    {
        if ($var == 'college') {
            return $this->_college;
        }
        throw new Exception('There\'s no var with that name');
    }
}