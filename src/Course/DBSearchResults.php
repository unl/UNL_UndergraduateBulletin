<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\Services\CourseApproval\Course\Course;

class DBSearchResults extends \LimitIterator implements
    \Countable
{
    protected $sql;
    protected $count;

    public function __construct($sql, $offset = 0, $limit = -1)
    {
        $this->sql = $sql;

        $stmnt = $this->getDB()->query($this->sql);

        if ($stmnt === false) {
            throw new \Exception('Invalid query result from the database', 500);
        }

        parent::__construct(new \IteratorIterator($stmnt), $offset, $limit);
    }

    public function current()
    {
        $xml = parent::current();
        return new Course(new \SimpleXMLElement($xml['xml']));
    }

    public function count()
    {
        $replacements = [
            'SELECT *',
            'SELECT courses.xml',
            'SELECT DISTINCT courses.id, courses.xml',
        ];

        if (!isset($this->count)) {
            $sql = str_replace($replacements, 'SELECT COUNT(DISTINCT courses.id) ', $this->sql);
            $result = $this->getDB()->query($sql);
            $count = $result->fetch(\PDO::FETCH_NUM);
            $this->count = $count[0];
        }

        return (int) $this->count;
    }

    /**
     * Get the database
     *
     * @return PDO
     */
    protected function getDB()
    {
        return DBSearcher::getDB();
    }
}
