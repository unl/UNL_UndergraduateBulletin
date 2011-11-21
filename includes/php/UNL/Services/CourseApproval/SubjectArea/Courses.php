<?php 
class UNL_Services_CourseApproval_SubjectArea_Courses extends ArrayIterator implements ArrayAccess
{
    protected $_subjectArea;
    
    protected $_xml;
    
    function __construct(UNL_Services_CourseApproval_SubjectArea $subjectarea)
    {
        $this->_subjectArea = $subjectarea;
        $this->_xml = new SimpleXMLElement(UNL_Services_CourseApproval::getXCRIService()->getSubjectArea($subjectarea->subject));
        //Fetch all namespaces
        $namespaces = $this->_xml->getNamespaces(true);
        $this->_xml->registerXPathNamespace('default', $namespaces['']);
        
        //Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $this->_xml->registerXPathNamespace($prefix, $ns);
        }

        parent::__construct($this->_xml->xpath('//default:courses/default:course'));
    }
    
    function current()
    {
        return new UNL_Services_CourseApproval_Course(parent::current());
    }
    
    function offsetSet($number, $value)
    {
        throw new Exception('Not implemented yet');
    }
    
    function offsetUnset($number)
    {
        throw new Exception('Not implemented yet');
    }
    
    function offsetExists($number)
    {
        throw new Exception('Not implemented yet');
    }
    
    function offsetGet($number)
    {
        $parts = array();
        if (!UNL_Services_CourseApproval_Course::validCourseNumber($number, $parts)) {
            throw new Exception('Invalid course number format '.$number);
        }
        
        if (!empty($parts['courseLetter'])) {
            $letter_check = "default:courseLetter='{$parts['courseLetter']}'";
        } else {
            $letter_check = 'not(default:courseLetter)';
        }
        
        $xpath = "//default:courses/default:course/default:courseCodes/default:courseCode[default:subject='{$this->_subjectArea->subject}' and default:courseNumber='{$parts['courseNumber']}' and $letter_check]/parent::*/parent::*";
        $courses = $this->_xml->xpath($xpath);

        if (false === $courses
            || !isset($courses[0])) {
            throw new Exception('No course was found matching '.$this->_subjectArea->subject.' '.$number, 404);
        }

        if (count($courses) > 1) {
            // Whoah whoah whoah, more than one course?
            throw new Exception('More than one course was found matching '.$this->_subjectArea->subject.' '.$number, 500);
        }

        return new UNL_Services_CourseApproval_Course($courses[0]);
    }
}

