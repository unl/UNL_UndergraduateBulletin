<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\GraduateController;
use UNL\Services\CourseApproval\Search\AbstractSearch;

class DBSearcher extends AbstractSearch
{
    protected $controller;

    protected $db;

    public static function getDatabasePath(Controller $controller = null)
    {
        $dataDir = Controller::getEdition()->getCourseDataDir();

        if ($controller) {
            $dataDir = $controller::getEdition()->getCourseDataDir();
        }

        return $dataDir . DIRECTORY_SEPARATOR . 'courses.sqlite';
    }

    public static function databaseExists(Controller $controller = null)
    {
        $dbPath = static::getDatabasePath($controller);
        return file_exists($dbPath);
    }

    public function __construct(Controller $controller = null)
    {
        $this->controller = $controller;
        $this->db = new \PDO('sqlite:' . static::getDatabasePath($controller));
    }

    public function getDB()
    {
        return $this->db;
    }

    public function filterQuery($query)
    {
        $query = trim($query);
        $query = str_replace(array('/', '"', '\'', '*', '%'), ' ', $query);
        return $query;
    }

    public function aceQuery($ace = null)
    {
        if (null == $ace) {
            return "courses.slo != ''";
        }

        if ($ace == 1) {
            return "courses.slo = '1' OR courses.slo LIKE '%1,%' OR courses.slo LIKE '%,1'";
        }

        return "courses.slo LIKE '%$ace%'";
    }

    public function aceAndNumberPrefixQuery($number)
    {
        $query = $this->numberPrefixQuery($number);
        $query .= ' AND courses.slo != ""';
        return $query;
    }

    public function subjectAndNumberPrefixQuery($subject, $number)
    {
        return "crosslistings.courseNumber LIKE '$number%' AND crosslistings.subjectArea='$subject'";
    }

    public function subjectAndNumberSuffixQuery($subject, $number)
    {
        return "crosslistings.courseNumber LIKE '%$number' AND crosslistings.subjectArea='$subject'";
    }

    public function numberPrefixQuery($number)
    {
        return "crosslistings.courseNumber LIKE '$number%'";
    }

    public function honorsQuery()
    {
        return 'crosslistings.courseNumber LIKE "%H"';
    }

    public function titleQuery($title)
    {
        return 'courses.title LIKE '.$this->getDB()->quote('%'.$title.'%');
    }

    public function subjectAreaQuery($subject)
    {
        return "crosslistings.subjectArea = '".$subject."'";
    }

    public function subjectAndNumberQuery($subject, $number, $letter = null)
    {
        if (isset($letter)) {
            $number .= $letter;
        }
        return $this->subjectAndNumberPrefixQuery($subject, $number);
    }

    public function numberQuery($number, $letter = null)
    {
        if (isset($letter)) {
            $number .= $letter;
        }
        return "crosslistings.courseNumber LIKE '$number%'";
    }

    public function numberSuffixQuery($number, $letter = null)
    {
        if (isset($letter)) {
            $number .= $letter;
        }
        return "crosslistings.courseNumber LIKE '%$number'";
    }

    public function creditQuery($credits)
    {
        return "courses.credits = {$credits}";
    }

    public function prerequisiteQuery($prereq)
    {
        $query = explode(' ', $prereq, 2);
        $sql = 'SELECT DISTINCT courses.id, courses.xml
FROM courses
INNER JOIN prereqs ON prereqs.course_id = courses.id
WHERE prereqs.subjectArea = ' . $this->getDB()->quote($query[0])
            . ' AND prereqs.courseNumber = ' . $this->getDB()->quote($query[1] ?: '');

        return new Select($sql);
    }

    public function intersectQuery($query1, $query2)
    {
        return $query1 . ' AND ' . $query2;
    }

    public function graduateQuery()
    {
        return 'crosslistings.courseNumber >= 500';
    }

    public function undergraduateQuery()
    {
        return 'crosslistings.courseNumber < 500';
    }

    public function getQueryResult($query, $offset = 0, $limit = -1)
    {
        if ($query instanceof Select) {
            $query = $query->__toString();
            return new DBSearchResults($this->db, $query, $offset, $limit);
        }

        $filterQuery = '';

        if (!$this->controller instanceof CatalogController) {
            $filterQuery = '(
    LENGTH(crosslistings.courseNumber) >= 3
    AND crosslistings.courseNumber < "500"
    OR LENGTH(crosslistings.courseNumber) < 3
) AND ';
        } elseif ($this->controller instanceof GraduateController) {
            $filterQuery = '(crosslistings.courseNumber >= "500") AND ';
        }

        $query =  'SELECT DISTINCT courses.id, courses.xml
FROM courses INNER JOIN crosslistings ON courses.id=crosslistings.course_id
WHERE ' . $filterQuery . ' (' . $query . ');';
        return new DBSearchResults($this->db, $query, $offset, $limit);
    }
}
