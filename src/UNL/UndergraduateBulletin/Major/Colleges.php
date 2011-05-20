<?php
class UNL_UndergraduateBulletin_Major_Colleges extends FilterIterator
{
    /**
     * The value from the college quickpoint for this major
     * 
     * @var array
     */
    protected $_colleges;

    function __construct($options = array())
    {
        if (!isset($options['colleges'])) {
            throw new Exception('You must pass a list of colleges');
        }
        $this->setColleges($options['colleges']);
        parent::__construct(new UNL_UndergraduateBulletin_CollegeList());
    }

    public function setColleges($colleges)
    {
        if (!is_array($colleges)) {
            $colleges = explode(',', $colleges);
        }
        array_walk($colleges, create_function('&$val', '$val = trim($val);'));
        $this->_colleges = $colleges;
    }

    function accept()
    {
        return $this->relationshipExists($this->current()->name);
    }

    /**
     * Checks if a relationship exists between this major and the given college
     *
     * @param string $college_name
     */
    public function relationshipExists($college_name)
    {
        return in_array($college_name, $this->_colleges);
    }
}