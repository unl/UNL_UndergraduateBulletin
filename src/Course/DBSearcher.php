<?php

namespace UNL\UndergraduateBulletin\Course;

use UNL\UndergraduateBulletin\Controller;
use UNL\Services\CourseApproval\Search\AbstractSearch;

class DBSearcher extends AbstractSearch
{
    public $options = [];

    protected static $db;

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;
    }

    public static function getDB()
    {
        if (!isset(static::$db)) {
            static::$db = new \PDO('sqlite:'. Controller::getEdition()->getCourseDataDir() . '/courses.sqlite');
        }
        return static::$db;
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
        return 'courses.title LIKE '.static::getDB()->quote('%'.$title.'%');
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
WHERE prereqs.subjectArea = ' . static::getDB()->quote($query[0])
            . ' AND prereqs.courseNumber = ' . static::getDB()->quote($query[1] ?: '');

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
            return new DBSearchResults($query, $offset, $limit);
        }

        $query =  'SELECT DISTINCT courses.id, courses.xml
FROM courses INNER JOIN crosslistings ON courses.id=crosslistings.course_id
WHERE (
    LENGTH(crosslistings.courseNumber) >= 3
    AND crosslistings.courseNumber < "500"
    OR LENGTH(crosslistings.courseNumber) < 3
) AND (' . $query . ');';
        return new DBSearchResults($query, $offset, $limit);
    }
}
