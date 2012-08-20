<?php 
class UNL_Services_CourseApproval_Course
{
    
    /**
     * The internal object
     * 
     * @var SimpleXMLElement
     */
    protected $_internal;

    /**
     * Collection of course codes
     * 
     * @var UNL_Services_CourseApproval_Course_Codes
     */
    public $codes;
    
    protected $_getMap = array('credits'         => 'getCredits',
                               'dfRemoval'       => 'getDFRemoval',
                               'campuses'        => 'getCampuses',
                               'deliveryMethods' => 'getDeliveryMethods',
                               'termsOffered'    => 'getTermsOffered',
                               'activities'      => 'getActivities',
                               'aceOutcomes'     => 'getACEOutcomes',
                               );

    protected $ns_prefix = '';

    function __construct(SimpleXMLElement $xml)
    {
        $this->_internal = $xml;
        //Fetch all namespaces
        $namespaces = $this->_internal->getNamespaces(true);
        if (isset($namespaces[''])
            && $namespaces[''] == 'http://courseapproval.unl.edu/courses') {
            $this->_internal->registerXPathNamespace('default', $namespaces['']);
            $this->ns_prefix = 'default:';

            //Register the rest with their prefixes
            foreach ($namespaces as $prefix => $ns) {
                $this->_internal->registerXPathNamespace($prefix, $ns);
            }
        }
        $this->codes = new UNL_Services_CourseApproval_Course_Codes($this->_internal->courseCodes->children());
    }
    
    function __get($var)
    {
        if (array_key_exists($var, $this->_getMap)) {
            return $this->{$this->_getMap[$var]}();
        }

        if (isset($this->_internal->$var)
            && count($this->_internal->$var->children())) {
            if (isset($this->_internal->$var->div)) {
                return str_replace(' xmlns="http://www.w3.org/1999/xhtml"', 
                                   '',
                                   html_entity_decode($this->_internal->$var->div->asXML()));
            }
        }

        return (string)$this->_internal->$var;
    }
    
    function __isset($var)
    {
        $elements = $this->_internal->xpath($this->ns_prefix.$var);
        if (count($elements)) {
            return true;
        }
        return false;
    }
    
    function getCampuses()
    {
        return $this->getArray('campuses');
    }
    
    function getTermsOffered()
    {
        return $this->getArray('termsOffered');
    }
    
    function getDeliveryMethods()
    {
        return $this->getArray('deliveryMethods');
    }
    
    function getActivities()
    {
        return new UNL_Services_CourseApproval_Course_Activities($this->_internal->activities->children());
    }
    
    function getACEOutcomes()
    {
        return $this->getArray('aceOutcomes');
    }
    
    function getArray($var)
    {
        $results = array();
        foreach ($this->_internal->$var->children() as $el) {
            $results[] = (string)$el;
        }
        return $results;
    }
    
    /**
     * Gets the types of credits offered for this course.
     * 
     * @return UNL_Services_CourseApproval_Course_Credits
     */
    function getCredits()
    {
        return new UNL_Services_CourseApproval_Course_Credits($this->_internal->credits->children());
    }
    
    /**
     * Checks whether this course can remove a previous grade of D or F for the same course.
     * 
     * @return bool
     */
    function getDFRemoval()
    {
        if ($this->_internal->dfRemoval == 'true') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Verifies that the course number is in the correct format.
     * 
     * @param $number The course number eg 201H, 4004I
     * @param $parts  Array of matched parts
     * 
     * @return bool
     */
    public static function validCourseNumber($number, &$parts = null)
    {
        $matches = array();
        if (preg_match('/^([\d]?[\d]{2,3})([A-Z])?$/i', $number, $matches)) {
            $parts['courseNumber'] = $matches[1];
            if (isset($matches[2])) {
                $parts['courseLetter'] = $matches[2];
            }
            return true;
        }
        
        return false;
    }
    
    public static function courseNumberFromCourseCode(SimpleXMLElement $xml)
    {
        $number = (string)$xml->courseNumber;
        if (isset($xml->courseLetter)) {
            $number .= (string)$xml->courseLetter;
        }
        return $number;
    }

    public static function getListingGroups(SimpleXMLElement $xml)
    {
        $groups = array();
        if (isset($xml->courseGroup)) {
            foreach ($xml->courseGroup as $group) {
                $groups[] = $group;
            }
        }
        return $groups;
    }
    
    function getHomeListing()
    {
        $home_listing = $this->_internal->xpath($this->ns_prefix.'courseCodes/'.$this->ns_prefix.'courseCode[@type="home listing"]');
        if ($home_listing === false
            || count($home_listing) < 1) {
            return false;
        }
        $number = UNL_Services_CourseApproval_Course::courseNumberFromCourseCode($home_listing[0]);
        return new UNL_Services_CourseApproval_Listing($home_listing[0]->subject,
                                                     $number,
                                                     UNL_Services_CourseApproval_Course::getListingGroups($home_listing[0]));
    }

    /**
     * Search for subsequent courses
     * 
     * (reverse prereqs)
     *
     * @param UNL_Services_CourseApproval_Search $search_driver
     *
     * @return UNL_Services_CourseApproval_Courses
     */
    function getSubsequentCourses($search_driver = null)
    {
        $searcher = new UNL_Services_CourseApproval_Search($search_driver);

        $query = $this->getHomeListing()->subjectArea.' '.$this->getHomeListing()->courseNumber;
        return $searcher->byPrerequisite($query);
    }
    
    function asXML()
    {
        return $this->_internal->asXML();
    }
}
