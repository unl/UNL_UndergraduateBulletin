<?php
class UNL_UndergraduateBulletin_CourseSearch_DBSearcher extends UNL_Services_CourseApproval_SearchInterface
{
    public $options = array();

    public static $db;

    function __construct($options = array())
    {
        $this->options = $options + $this->options;
    }
    
    public static function getDB()
    {
        if (!isset(self::$db)) {
            self::$db = new PDO('sqlite:'.UNL_UndergraduateBulletin_Controller::getEdition()->getCourseDataDir().'/courses.sqlite');
        }
        return self::$db;
    }

    function filterQuery($query)
    {
        $query = trim($query);

        $query = str_replace(array('/', '"', '\'', '*', '%'), ' ', $query);

        return $query;
    }
    
    function aceQuery($ace)
    {
        if ($ace == 1) {
            return "courses.slo = '1' OR courses.slo LIKE '%1,%' OR courses.slo LIKE '%,1'";
        }

        return "courses.slo LIKE '%$ace%'";
    }

    function aceAndNumberPrefixQuery($number)
    {
        $query = $this->numberPrefixQuery($number);
        $query .= ' AND courses.slo != ""';
        return $query;
    }
    
    function subjectAndNumberPrefixQuery($subject, $number)
    {
        return "crosslistings.courseNumber LIKE '$number%' AND crosslistings.subjectArea='$subject'";
    }
    
    function numberPrefixQuery($number)
    {
        return "crosslistings.courseNumber LIKE '$number%'";
    }
    
    function honorsQuery()
    {
        return 'crosslistings.courseNumber LIKE "%H"';
    }

    function titleQuery($title)
    {
        return 'courses.title LIKE '.self::getDB()->quote('%'.$title.'%');
    }
    
    function subjectAreaQuery($subject)
    {
        return "crosslistings.subjectArea = '".$subject."'";
    }
    
    function subjectAndNumberQuery($subject, $number, $letter = null)
    {
        if (isset($letter)) {
            $number .= $letter;
        }
        return $this->subjectAndNumberPrefixQuery($subject, $number);
    }
    
    function numberQuery($number, $letter = null)
    {
        if (isset($letter)) {
            $number .= $letter;
        }
        return "crosslistings.courseNumber LIKE '$number%'";
    }

    function creditQuery($credits)
    {
        return "courses.credits = {$credits}";
    }

    function prerequisiteQuery($prereq)
    {
        return 'courses.prerequisite LIKE '.self::getDB()->quote('%'.$prereq.'%');
    }

    function intersectQuery($query1, $query2)
    {
        return $query1 . ' AND ' . $query2;
    }

    function graduateQuery()
    {
        return 'crosslistings.courseNumber >= 500';
    }

    function undergraduateQuery()
    {
        return 'crosslistings.courseNumber < 500';
    }

    function getQueryResult($query, $offset = 0, $limit = -1)
    {
        $query =  'SELECT DISTINCT courses.id, courses.xml 
                   FROM courses INNER JOIN crosslistings ON courses.id=crosslistings.course_id
                   WHERE (
                          LENGTH(crosslistings.courseNumber) = 3
                          AND crosslistings.courseNumber < "500"
                          OR LENGTH(crosslistings.courseNumber) < 3
                         )
                         AND (' . $query . ');';
        return new UNL_UndergraduateBulletin_CourseSearch_DBSearchResults($query, $offset, $limit);
    }
}