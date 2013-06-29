<?php
/**
 * 
 * Course search driver which uses XPath queries on the course XML data
 * 
 * @author Brett Bieber <brett.bieber@gmail.com>
 *
 */
class UNL_Services_CourseApproval_SearchInterface_XPath extends UNL_Services_CourseApproval_SearchInterface
{
    /**
     * SimpleXMLElement for all courses
     * 
     * @var SimpleXMLElement
     */
    protected static $all_courses;

    protected static $courses = array();

    const XML_BASE = '/default:courses/default:course/';

    /**
     * Get all courses in a SimpleXMLElement
     * 
     * @return SimpleXMLElement
     */
    protected static function getCourses()
    {
        if (!isset(self::$all_courses)) {
            $xml = UNL_Services_CourseApproval::getXCRIService()->getAllCourses();
            self::$all_courses = new SimpleXMLElement($xml);

            //Fetch all namespaces
            $namespaces = self::$all_courses->getNamespaces(true);
            self::$all_courses->registerXPathNamespace('default', $namespaces['']);

            //Register the rest with their prefixes
            foreach ($namespaces as $prefix => $ns) {
                self::$all_courses->registerXPathNamespace($prefix, $ns);
            }
        }

        return self::$all_courses;
    }

    /**
     * Get the XML for a specific subject area as a SimpleXMLElement
     * 
     * @param string $subjectarea Course subject area e.g. CSCE
     * 
     * @return SimpleXMLElement
     */
    protected static function getSubjectAreaCourses($subjectarea)
    {
        if (!isset(self::$courses[$subjectarea])) {
            $xml = UNL_Services_CourseApproval::getXCRIService()->getSubjectArea($subjectarea);
            self::$courses[$subjectarea] = new SimpleXMLElement($xml);

            //Fetch all namespaces
            $namespaces = self::$courses[$subjectarea]->getNamespaces(true);
            self::$courses[$subjectarea]->registerXPathNamespace('default', $namespaces['']);

            //Register the rest with their prefixes
            foreach ($namespaces as $prefix => $ns) {
                self::$courses[$subjectarea]->registerXPathNamespace($prefix, $ns);
            }
        }

        return self::$courses[$subjectarea];
    }

    /**
     * Utility method to trim out characters which aren't safe for XPath queries
     * 
     * @param string $query Search string
     * 
     * @return string
     */
    function filterQuery($query)
    {
        $query = trim($query);

        $query = str_replace(array('/', '"', '\'', '*'), ' ', $query);
        return $query;
    }

    /**
     * Set the courses data to perform searches on
     * 
     * @param SimpleXMLElement $courses Set of courses to search
     */
    public function setCourses(SimpleXMLElement $courses)
    {
        self::$courses = $courses;
    }

    /**
     * Construct a query for courses matching an Achievement Centered Education (ACE) number
     * 
     * @param string|int $ace Achievement Centered Education (ACE) number, e.g. 1-10
     * 
     * @return string XPath query
     */
    function aceQuery($ace)
    {
        return "default:aceOutcomes[default:slo='$ace']/parent::*";
    }

    /**
     * Construct a query for Achievement Centered Education (ACE) courses which
     * have a course number prefix
     * 
     * @param string|int $number Number prefix, e.g. 1 for 100 level ACE courses
     * 
     * @return string XPath query
     */
    function aceAndNumberPrefixQuery($number)
    {
        return "default:courseCodes/default:courseCode/default:courseNumber[starts-with(., '$number')]/parent::*/parent::*/parent::*/default:aceOutcomes/parent::*";
    }

    /**
     * Construct a query for courses matching a subject and number prefix
     * 
     * @param string     $subject Subject code, e.g. CSCE
     * @param string|int $number  Course number prefix, e.g. 2 for 200 level courses
     * 
     * @return string XPath query
     */
    function subjectAndNumberPrefixQuery($subject, $number)
    {
        return "default:courseCodes/default:courseCode[starts-with(default:courseNumber, '$number') and default:subject='$subject']/parent::*/parent::*";
    }

    /**
     * Construct a query for courses matching a subject and number suffix
     * 
     * @param string     $subject Subject code, e.g. MUDC
     * @param string|int $number  Course number prefix, e.g. 41 for 241, 341, 441
     * 
     * @return string XPath query
     */
    function subjectAndNumberSuffixQuery($subject, $number)
    {
        return "default:courseCodes/default:courseCode[('$number' = substring(default:courseNumber,string-length(default:courseNumber)-string-length('$number')+1)) and default:subject='$subject']/parent::*/parent::*";
    }

    /**
     * Construct a query for courses matching a number prefix
     * 
     * @param string|int $number  Course number prefix, e.g. 2 for 200 level courses
     * 
     * @return string XPath query
     */
    function numberPrefixQuery($number)
    {
        return "default:courseCodes/default:courseCode/default:courseNumber[starts-with(., '$number')]/parent::*/parent::*/parent::*";
    }

    /**
     * Construct a query for courses matching a number suffix
     * 
     * @param string|int $number  Course number suffix, e.g. 41 for 141, 241, 341 etc
     * 
     * @return string XPath query
     */
    function numberSuffixQuery($number)
    {
        return "default:courseCodes/default:courseCode/default:courseNumber['$number' = substring(., string-length(.)-string-length('$number')+1)]/parent::*/parent::*/parent::*";
    }

    /**
     * Construct a query for honors courses
     * 
     * @return string XPath query
     */
    function honorsQuery()
    {
        return "default:courseCodes/default:courseCode[default:courseLetter='H']/parent::*/parent::*";
    }

    /**
     * Construct a query for courses with a title matching the query
     * 
     * @param string $title Portion of the title of the course
     * 
     * @return string XPath query
     */
    function titleQuery($title)
    {
        return 'default:title['.$this->caseInsensitiveXPath($title).']/parent::*';
    }

    /**
     * Construct a query for courses matching a subject area
     * 
     * @param string $subject Subject code, e.g. CSCE
     * 
     * @return string XPath query
     */
    function subjectAreaQuery($subject)
    {
        return "default:courseCodes/default:courseCode[default:subject='$subject']/parent::*/parent::*";
    }

    /**
     * Construct a query for courses matching a subject and number
     * 
     * @param string     $subject Subject code, e.g. CSCE
     * @param string|int $number  Course number, e.g. 201
     * @param string     $letter  Optional course letter, e.g. H
     * 
     * @return string XPath query
     */
    function subjectAndNumberQuery($subject, $number, $letter = null)
    {
        return "default:courseCodes/default:courseCode[default:courseNumber='$number'{$this->courseLetterCheck($letter)} and default:subject='$subject']/parent::*/parent::*";
    }

    /**
     * Construct a query for courses matching a number
     * 
     * @param string|int $number Course number, e.g. 201
     * @param string     $letter Optional course letter, e.g. H
     * 
     * @return string XPath query
     */
    function numberQuery($number, $letter = null)
    {
        return "default:courseCodes/default:courseCode[default:courseNumber='$number'{$this->courseLetterCheck($letter)}]/parent::*/parent::*";
    }

    /**
     * Construct a query for undergraduate courses
     * 
     * @return string XPath query
     */
    function undergraduateQuery()
    {
        return "default:courseCodes/default:courseCode[default:courseNumber<'500']/parent::*/parent::*";
    }

    /**
     * Construct a query for graduate courses
     * 
     * @return string XPath query
     */
    function graduateQuery()
    {
        return "default:courseCodes/default:courseCode[default:courseNumber>='500']/parent::*/parent::*";
    }

    /**
     * Construct part of an XPath query for matching a course letter
     *
     * @param string $letter Letter, e.g. H
     *
     * @return string
     */
    protected function courseLetterCheck($letter = null)
    {
        $letter_check = '';
        if (!empty($letter)) {
            $letter_check = " and (default:courseLetter='".strtoupper($letter)."' or default:courseLetter='".strtolower($letter)."')";
        }
        return $letter_check;
    }

    /**
     * Construct a query for courses with the required number of credits
     * 
     * @param string|int $credits Course credits
     * 
     * @return string XPath query
     */
    function creditQuery($credits)
    {
        return "default:courseCredits[default:credit='$credits']/parent::*/parent::*";
    }

    /**
     * Construct a query for courses with prerequisites matching the query
     * 
     * @param string $prereq Query to search prereqs for
     * 
     * @return string XPath query
     */
    function prerequisiteQuery($prereq)
    {
        return 'default:prerequisite['.$this->caseInsensitiveXPath($prereq).']/parent::*';
    }

    /**
     * Convert a query to a case-insensitive XPath contains query
     *
     * @param string $query The query to search for
     * 
     * @return string
     */
    protected function caseInsensitiveXPath($query)
    {
        $query = strtolower($query);
        return 'contains(translate(.,"ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"),"'.$query.'")';
    }

    /**
     * Combine two XPath queries into one which will return the intersect
     *
     * @return string
     */
    public function intersectQuery($query1, $query2)
    {
        return $query1 . '/' . $query2;
    }

    /**
     * Execute the supplied query and return matching results
     * 
     * @param string $query  XPath compatible query
     * @param int    $offset Offset for pagination of search results
     * @param int    $limit  Limit for the number of results returned
     * 
     * @return UNL_Services_CourseApproval_Search_Results
     */
    function getQueryResult($query, $offset = 0, $limit = -1)
    {
        // prepend XPath XML Base
        $query = self::XML_BASE . $query;

        $result = self::getCourses()->xpath($query);

        if ($result === false) {
            $result = array();
        }

        return new UNL_Services_CourseApproval_Search_Results($result, $offset, $limit);
    }
}