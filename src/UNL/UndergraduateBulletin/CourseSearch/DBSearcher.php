<?php
class UNL_UndergraduateBulletin_CourseSearch_DBSearcher
{
    public $options = array('q'=>'');

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
    
    public function byAny($query, $offset = 0, $limit = null)
    {

        $query = trim($query);

        $query = str_replace(array('/', '"', '\'', '*', '%'), ' ', $query);

        switch (true) {
            case preg_match('/^ace\s*:?\s*(10|[1-9])$/i', $query, $match):
                // ACE outcome number
                if ($match[1] == '1') {
                    $sql = "SELECT courses.xml FROM courses WHERE slo = '1' OR slo LIKE '%1,%' OR slo LIKE '%,1'";
                } else {
                    $sql = "SELECT courses.xml FROM courses WHERE slo LIKE '%{$match[1]}%';";
                }
                break;
            case preg_match('/^([A-Z]{3,4})\s+([0-9])XX$/i', $query, $matches):
                // Course subject and number range, eg: MRKT 3XX
                $subject = strtoupper($matches[1]);

                $sql = "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE '$matches[2]%' AND crosslistings.subjectArea = '".$subject."'";
                break;
            case preg_match('/^([A-Z]{3,4})\s+([\d]?[\d]{2,3}[A-Z]?):?.*$/i', $query, $matches):
                // Course subject code and number
                $subject = strtoupper($matches[1]);
                
                $number = strtoupper($matches[2]);

                $sql = "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE '$number%' AND crosslistings.subjectArea='$subject';";
                break;
            case preg_match('/^([0-9])XX$/i', $query, $match):
                // Course number range
                $sql = "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE '$match[1]%';";
                break;
            case preg_match('/^([\d]?[\d]{2,3})([A-Z])?$/i', $query):
                // Course Number
                $num_parts = array();
                UNL_Services_CourseApproval_Course::validCourseNumber($query, $num_parts);

                $number = $num_parts['courseNumber'];
                if (!empty($num_parts['courseLetter'])) {
                    $number .= strtoupper($num_parts['courseLetter']);
                }

                $sql = "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE '$number%';";
                break;
            case preg_match('/^([A-Z]{3,4})(\s*:\s*.*)?$/', $query, $matches):
                // Subject code search
                $subject = $matches[1];
                $sql = "SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.subjectArea = '".$subject."'";
                break;
            case preg_match('/^honors$/i', $query):
                $sql = 'SELECT courses.xml FROM courses, crosslistings WHERE crosslistings.course_id = courses.id AND crosslistings.courseNumber LIKE "%H";';
                break;
            default:
                // Do a title text search
                $sql = 'SELECT courses.xml FROM courses WHERE title LIKE '.UNL_UndergraduateBulletin_CourseSearch_DBSearcher::getDB()->quote('%'.$query.'%').';';
        }

        $result = new UNL_UndergraduateBulletin_CourseSearch_DBSearchResults($sql, $offset, $limit);
        return $result;
    }
}