<?php
class UNL_Services_CourseApproval_SearchInterface_XPath extends UNL_Services_CourseApproval_SearchInterface
{
    /**
     * SimpleXMLElement for all courses
     * 
     * @var SimpleXMLElement
     */
    protected static $all_courses;
    
    protected static $courses = array();
    
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
    
    function filterQuery($query)
    {
        $query = trim($query);

        $query = str_replace(array('/', '"', '\'', '*'), ' ', $query);
        return $query;
    }
    
    public function setCourses(SimpleXMLElement $courses)
    {
        self::$courses = $courses;
    }
    
    function aceQuery($ace)
    {
        return "/default:courses/default:course/default:aceOutcomes[default:slo='$ace']/parent::*";
    }

    function aceAndNumberPrefixQuery($number)
    {
        return "/default:courses/default:course/default:courseCodes/default:courseCode/default:courseNumber[starts-with(., '$number')]/parent::*/parent::*/parent::*/default:aceOutcomes/parent::*";
    }
    
    function subjectAndNumberPrefixQuery($subject, $number)
    {
        return "/default:courses/default:course/default:courseCodes/default:courseCode[starts-with(default:courseNumber, '$number') and default:subject='$subject']/parent::*/parent::*";
    }
    
    function numberPrefixQuery($number)
    {
        return "/default:courses/default:course/default:courseCodes/default:courseCode/default:courseNumber[starts-with(., '$number')]/parent::*/parent::*/parent::*";
    }
    
    function honorsQuery()
    {
        return "/default:courses/default:course/default:courseCodes/default:courseCode[default:courseLetter='H']/parent::*/parent::*";
    }

    function titleQuery($title)
    {
        $title = strtolower($title);
        return '/default:courses/default:course/default:title[contains(translate(.,"ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"),"'.$title.'")]/parent::*';
    }
    
    function subjectAreaQuery($subject)
    {
        return "/default:courses/default:course/default:courseCodes/default:courseCode[default:subject='$subject']/parent::*/parent::*";
    }
    
    function subjectAndNumberQuery($subject, $number, $letter = null)
    {
        $letter_check = '';
        if (!empty($letter)) {
            $letter_check = " and (default:courseLetter='".strtoupper($letter)."' or default:courseLetter='".strtolower($letter)."')";
        }
        return "/default:courses/default:course/default:courseCodes/default:courseCode[default:courseNumber='$number'$letter_check and default:subject='$subject']/parent::*/parent::*";
    }
    
    function numberQuery($number, $letter = null)
    {
        $letter_check = '';
        if (isset($letter)) {
            $letter_check = " and (default:courseLetter='".strtoupper($letter)."' or default:courseLetter='".strtolower($letter)."')";
        }

        return "/default:courses/default:course/default:courseCodes/default:courseCode[default:courseNumber='$number'$letter_check]/parent::*/parent::*";
    }

    function creditQuery($credits)
    {
        return "/default:courses/default:course/default:courseCredits[default:credit='$credits']/parent::*/parent::*";
    }

	function prerequisiteQuery($prereq)
    {
        $prereq = strtolower($prereq);
        return '/default:courses/default:course/default:prerequisite[contains(translate(.,"ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"),"'.$prereq.'")]/parent::*';
    }
    
    function getQueryResult($query, $offset = 0, $limit = null)
    {
        $result = self::getCourses()->xpath($query);

        if ($result === false) {
            $result = array();
        }

        return new UNL_Services_CourseApproval_Search_Results($result, $offset, $limit);
    }
}