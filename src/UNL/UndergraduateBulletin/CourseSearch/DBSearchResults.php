<?php
class UNL_UndergraduateBulletin_CourseSearch_DBSearchResults extends LimitIterator implements Countable
{
    protected $sql;
    
    function __construct($sql, $offset, $limit)
    {
        $this->sql = $sql;

        $stmnt = $this->getDB()->query($this->sql);

        if ($stmnt === false) {
            throw new Exception('Invalid query result from the database', 500);
        }

        parent::__construct(new IteratorIterator($stmnt), $offset, $limit);
    }
    
    function current()
    {
        $xml = parent::current();
        return new UNL_Services_CourseApproval_Course(new SimpleXMLElement($xml['xml']));
    }
    
    function count()
    {
        $sql = str_replace(array('SELECT * ', 'SELECT courses.xml ', 'SELECT DISTINCT courses.id, courses.xml '), 'SELECT COUNT(DISTINCT courses.id) ', $this->sql);
        $result = $this->getDB()->query($sql);
        $count = $result->fetch(PDO::FETCH_NUM);
        return $count[0];
    }

    /**
     * Get the database
     *
     * @return PDO
     */
    protected function getDB()
    {
        return UNL_UndergraduateBulletin_CourseSearch_DBSearcher::getDB();
    }
}