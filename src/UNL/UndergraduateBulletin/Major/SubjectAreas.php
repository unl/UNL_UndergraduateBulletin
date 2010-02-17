<?php
class UNL_UndergraduateBulletin_Major_SubjectAreas implements ArrayAccess, Countable, Iterator
{
    public $major;
    
    protected $_areas = array();
    
    function __construct($major)
    {
        $this->major = $major;
        switch ($this->major->title) {
            case 'Advertising':
                $this->_areas['ADVT'] = new UNL_Services_CourseApproval_SubjectArea('ADVT');
                break;
            case 'Geography':
                $this->_areas['GEOG'] = new UNL_Services_CourseApproval_SubjectArea('GEOG');
                break;
        }
    }
    
    function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_areas);
    }
    
    function offsetGet($offset)
    {
        throw new Exception('TODO');
    }
    
    function offsetSet($offset, $val)
    {
        throw new Exception('TODO');
    }
    
    function offsetUnset($offset)
    {
        throw new Exception('TODO');
    }
    
    function count()
    {
        return count($this->_areas);
    }
    
    function current()
    {
        return current($this->_areas);
    }
    
    function next()
    {
        next($this->_areas);
    }
    
    function key()
    {
        return key($this->_areas);
    }
    
    function valid()
    {
        if (current($this->_areas) === false) {
            return false;
        }
        return true;
    }
    
    function rewind()
    {
        reset($this->_areas);
    }
}
?>