<?php
class UNL_UndergraduateBulletin_CourseSearch_DBSearchResults extends LimitIterator implements Countable
{
    protected $sql;
    
    function __construct($sql, $offset, $limit)
    {
        $this->sql = $sql;

        $stmnt = UNL_UndergraduateBulletin_CourseSearch_DBSearcher::getDB()->query($this->sql);
        parent::__construct(new IteratorIterator($stmnt), $offset, $limit);
    }
    
    function current()
    {
        $xml = parent::current();
        return new UNL_Services_CourseApproval_Course(new SimpleXMLElement($xml['xml']));
    }
    
    function count()
    {
        $sql = str_replace(array('SELECT * ', 'SELECT courses.xml '), 'SELECT COUNT(courses.id) ', $this->sql);
        $result = UNL_UndergraduateBulletin_CourseSearch_DBSearcher::getDB()->query($sql);
        $count = $result->fetch(PDO::FETCH_NUM);
        return $count[0];
    }
}