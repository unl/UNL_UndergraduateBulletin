<?php 
class UNL_Services_CourseApproval_SubjectArea_Courses extends ArrayIterator implements ArrayAccess
{
    const DEFAULT_NS = 'default';
    const DEFAULT_XPATH = '//default:courses/default:course';
    
    protected $_subjectArea;
    
    protected $_xml;
    
    protected $_offsetLookupCache = array();
    
    function __construct(UNL_Services_CourseApproval_SubjectArea $subjectarea)
    {
        $this->_subjectArea = $subjectarea;
        $this->_xml = new SimpleXMLElement(UNL_Services_CourseApproval::getXCRIService()->getSubjectArea($subjectarea->subject));
        //Fetch all namespaces
        $namespaces = $this->_xml->getNamespaces(true);
        $this->_xml->registerXPathNamespace(self::DEFAULT_NS, $namespaces['']);
        
        //Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $this->_xml->registerXPathNamespace($prefix, $ns);
        }

        parent::__construct($this->_xml->xpath(self::DEFAULT_XPATH));
    }
    
    protected function createCourse(SimpleXMLElement $xml)
    {
        $course = new UNL_Services_CourseApproval_Course($xml);
        $course->subject = $this->_subjectArea->subject;
        
        return $course;
    }
    
    function current()
    {
        return $this->createCourse(parent::current());
    }
    
    function offsetSet($number, $value)
    {
        throw new Exception('Not implemented yet');
    }
    
    function offsetUnset($number)
    {
        throw new Exception('Not implemented yet');
    }
    
    protected function offsetLookup($number)
    {
        if (!isset($this->_offsetLookupCache[$number])) {
            $parts = array();
            if (!UNL_Services_CourseApproval_Course::validCourseNumber($number, $parts)) {
                throw new Exception('Invalid course number format '.$number);
            }
            
            if (!empty($parts['courseLetter'])) {
                $letter_check = self::DEFAULT_NS . ":courseLetter='{$parts['courseLetter']}'";
            } else {
                $letter_check = 'not(' . self::DEFAULT_NS . ':courseLetter)';
            }
            
            $xpath = sprintf('%1$s/%2$s:courseCodes/%2$s:courseCode[%2$s:subject=\'%3$s\' and %2$s:courseNumber=\'%4$s\' and %5$s]/parent::*/parent::*', 
                self::DEFAULT_XPATH, 
                self::DEFAULT_NS, 
                $this->_subjectArea->subject, 
                $parts['courseNumber'],
                $letter_check
            );
            
            $courses = $this->_xml->xpath($xpath);
            $this->_offsetLookupCache[$number] = $courses;
        }
        
        return $this->_offsetLookupCache[$number];
    }
    
    public function offsetExists($number)
    {
        try {
            $lookup = $this->offsetLookup($number);
        } catch (Exception $e) {
            $lookup = null;
        }
        
        return !empty($lookup);
    }
    
    public function offsetGet($number)
    {
        $courses = $this->offsetLookup($number);

        if (empty($courses)) {
            throw new Exception('No course was found matching '.$this->_subjectArea->subject.' '.$number, 404);
        }

        if (count($courses) > 1) {
            // Whoah whoah whoah, more than one course?
            throw new Exception('More than one course was found matching '.$this->_subjectArea->subject.' '.$number, 500);
        }
        
        return $this->createCourse(current($courses));
    }
}

