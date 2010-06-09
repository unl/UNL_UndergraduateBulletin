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
            self::$db = new PDO('sqlite:'.UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/courses.sqlite');
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
            return "SELECT courses.xml FROM courses WHERE slo = '1' OR slo LIKE '%1,%' OR slo LIKE '%,1'";
        }

        return "SELECT courses.xml FROM courses WHERE slo LIKE '%$ace%';";
    }
    
    function subjectAndNumberPrefixQuery($subject, $number)
    {
        return "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE '$number%' AND crosslistings.subjectArea='$subject';";
    }
    
    function numberPrefixQuery($number)
    {
        return "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE '$number%';";
    }
    
    function honorsQuery()
    {
        return 'SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE "%H";';
    }

    function titleQuery($title)
    {
        return 'SELECT courses.xml FROM courses WHERE title LIKE '.self::getDB()->quote('%'.$title.'%').';';
    }
    
    function subjectAreaQuery($subject)
    {
        return "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.subjectArea = '".$subject."'";
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
        return "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE '$number%';";
    }

    function getQueryResult($query, $offset = 0, $limit = null)
    {
        return new UNL_UndergraduateBulletin_CourseSearch_DBSearchResults($query, $offset, $limit);
    }
}