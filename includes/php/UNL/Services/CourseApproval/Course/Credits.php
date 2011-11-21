<?php 

class UNL_Services_CourseApproval_Course_Credits implements Countable, ArrayAccess
{
    protected $_xmlCredits;
    
    protected $_currentCredit = 0;
    
    function __construct(SimpleXMLElement $xml)
    {
        $this->_xmlCredits = $xml;
    }
    
    function current()
    {
        return $this->_xmlCredits[$this->_currentCredit];
    }
    
    function next()
    {
        ++$this->_currentCredit;
    }
    
    function rewind()
    {
        $this->_currentCredit = 0;
    }
    
    function valid()
    {
        if ($this->_currentCredit >= $this->count()) {
            return false;
        }
        return true;
    }
    
    function count()
    {
        return count($this->_xmlCredits);
    }
    
    function key()
    {
        $credit = $this->current();
        return $credit['creditType'];
    }
    
    function offsetExists($type)
    {
        foreach ($this->_xmlCredits as $credit) {
            if ($credit['type'] == $type) {
                return true;
            }
        }
        return false;
    }
    
    function offsetGet($type)
    {
        foreach ($this->_xmlCredits as $credit) {
            if ($credit['type'] == $type) {
                return (int)$credit;
            }
        }
    }
    
    function offsetSet($type, $var)
    {
        throw new Exception('Not available.');
    }
    
    function offsetUnset($type)
    {
        throw new Exception('Not available.');
    }
}
