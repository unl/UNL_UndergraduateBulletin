<?php
class UNL_UndergraduateBulletin_CourseSearch_DBSearchResults extends LimitIterator implements Countable
{
    protected $sql;
    protected $count;
    
    function __construct($sql, $offset = 0, $limit = -1)
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
        if (!isset($this->count)) {
            $sql = str_replace(array('SELECT *', 'SELECT courses.xml', 'SELECT DISTINCT courses.id, courses.xml'), 'SELECT COUNT(DISTINCT courses.id) ', $this->sql);
            $result = $this->getDB()->query($sql);
            $count = $result->fetch(PDO::FETCH_NUM);
            $this->count = $count[0];
        }

        return $this->count;
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