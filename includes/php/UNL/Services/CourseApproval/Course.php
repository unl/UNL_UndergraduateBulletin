<?php 
class UNL_Services_CourseApproval_Course
{
    const DEFAULT_NS = 'default';
    const DEFAULT_NS_PREFIX = 'default:';
    
    const COURSE_CODE_TYPE_HOME = 'home listing';
    const COURSE_CODE_TYPE_CROSS = 'crosslisting';
    const COURSE_CODE_TYPE_GRAD = 'grad tie-in';
    
    /**
     * The subject area the course was loaded for/from
     * 
     * @var string $subject
     */
    public $subject;
    
    /**
     * The listing to use to render listing specific information
     * 
     * @var UNL_Services_CourseApproval_Listing $renderListing
     */
    protected $renderListing;
    
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
    
    protected $_getMap = array(
        'credits' => 'getCredits',
        'dfRemoval' => 'getDFRemoval',
        'campuses' => 'getCampuses',
        'deliveryMethods' => 'getDeliveryMethods',
        'termsOffered' => 'getTermsOffered',
        'activities' => 'getActivities',
        'aceOutcomes' => 'getACEOutcomes',
    );

    protected $ns_prefix = '';

    public function __construct(SimpleXMLElement $xml)
    {
        $this->_internal = $xml;
        //Fetch all namespaces
        $namespaces = $this->_internal->getNamespaces(true);
        if (isset($namespaces['']) && $namespaces[''] == 'http://courseapproval.unl.edu/courses') {
            $this->_internal->registerXPathNamespace(self::DEFAULT_NS, $namespaces['']);
            $this->ns_prefix = self::DEFAULT_NS_PREFIX;

            //Register the rest with their prefixes
            foreach ($namespaces as $prefix => $ns) {
                $this->_internal->registerXPathNamespace($prefix, $ns);
            }
        }
        $this->codes = new UNL_Services_CourseApproval_Course_Codes($this, $this->_internal->courseCodes->children());
    }
    
    public function __get($var)
    {
        if (array_key_exists($var, $this->_getMap)) {
            return $this->{$this->_getMap[$var]}();
        }

        if (isset($this->_internal->$var)  && count($this->_internal->$var->children())) {
            if (isset($this->_internal->$var->div)) {
                return strip_tags(html_entity_decode($this->_internal->$var->div->asXML()));
            }
        }

        return (string) $this->_internal->$var;
    }
    
    public function __isset($var)
    {
        $elements = $this->_internal->xpath($this->ns_prefix . $var);
        if (count($elements)) {
            return true;
        }
        return false;
    }
    
    public function getCampuses()
    {
        return $this->getArray('campuses');
    }
    
    public function getTermsOffered()
    {
        return $this->getArray('termsOffered');
    }
    
    public function getDeliveryMethods()
    {
        return $this->getArray('deliveryMethods');
    }
    
    public function getActivities()
    {
        return new UNL_Services_CourseApproval_Course_Activities($this->_internal->activities->children());
    }
    
    public function getACEOutcomes()
    {
        return $this->getArray('aceOutcomes');
    }
    
    public function getArray($var)
    {
        $results = array();
        
        if (isset($this->_internal->$var)) {
            foreach ($this->_internal->$var->children() as $el) {
                $results[] = (string)$el;
            }
        }
        
        return $results;
    }
    
    /**
     * Gets the types of credits offered for this course.
     * 
     * @return UNL_Services_CourseApproval_Course_Credits
     */
    public function getCredits()
    {
        if (!$this->_internal->credits) {
            return array();
        }
        return new UNL_Services_CourseApproval_Course_Credits($this->_internal->credits->children());
    }
    
    /**
     * Checks whether this course can remove a previous grade of D or F for the same course.
     * 
     * @return bool
     */
    public function getDFRemoval()
    {
        if ($this->_internal->dfRemoval == 'true') {
            return true;
        }
        
        return false;
    }
    
    public function setRenderListing(UNL_Services_CourseApproval_Listing $listing) {
        $this->renderListing = $listing;
    }
    
    public function getRenderListing()
    {
        if (!$this->renderListing) {
            if (isset($this->subject)) {
                foreach ($this->codes as $listing) {
                    if ($listing->subjectArea == $this->subject) {
                        return $listing;
                    }
                }
                
                return null;
            } else {
                return $this->getHomeListing();
            }
        }
        
        return $this->renderListing;
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
    
    protected function getCourseCodeByType($type)
    {
        return $this->_internal->xpath($this->ns_prefix . 'courseCodes/' . $this->ns_prefix . 'courseCode[@type="' . $type . '"]');
    }
    
    public function getHomeListing()
    {
        return $this->getListingByType(self::COURSE_CODE_TYPE_HOME);
    }
    
    /**
     * Returns the first listing object that represents the interal courseCode with the given type
     * 
     * @param string $type
     * @return UNL_Services_CourseApproval_Listing
     */
    public function getListingByType($type)
    {
        $courseCode = $this->getCourseCodeByType($type);
        
        if (empty($courseCode)) {
            return null;
        }
        
        return $this->getListingFromCourseCode(current($courseCode));
    }
    
    /**
     * Returns all of the listing objects that match the given type
     * 
     * @param string $type
     * @return UNL_Services_CourseApproval_Listing[]
     */
    public function getListingsByType($type)
    {
        $listings = array();
        $courseCode = $this->getCourseCodeByType($type);
        
        if (empty($courseCode)) {
            return $listings;
        }
        
        foreach ($courseCode as $courseCodeXml) {
            $listings[] = $this->getListingFromCourseCode($courseCodeXml);
        }
        
        return $listings;
    }
    
    /**
     * Returns a listing object that represents the internal courseCode
     * 
     * @param SimpleXMLElement $xml XML Object representing the courseCode
     * @return UNL_Services_CourseApproval_Listing
     */
    public function getListingFromCourseCode($xml)
    {
        $type = $xml['type'];
        $subject = $xml->subject;
        $number = self::courseNumberFromCourseCode($xml);
        $groups = self::getListingGroups($xml);
        
        return new UNL_Services_CourseApproval_Listing($this, $subject, $number, $type, $groups);
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
    public function getSubsequentCourses($search_driver = null)
    {
        $searcher = new UNL_Services_CourseApproval_Search($search_driver);
        $homeListing = $this->getHomeListing();

        $query = $homeListing->subjectArea . ' ' . $homeListing->courseNumber;
        return $searcher->byPrerequisite($query);
    }
    
    public function asXML()
    {
        return $this->_internal->asXML();
    }

    public static function getPossibleActivities()
    {
        //Value=>Description
        return array(
            'lec' => 'Lecture',
            'lab' => 'Lab',
            'stu' => 'Studio',
            'fld' => 'Field',
            'quz' => 'Quiz',
            'rct' => 'Recitation',
            'ind' => 'Independent Study',
            'psi' => 'Personalized System of Instruction',
        );
    }

    public static function getPossibleAceOutcomes()
    {
        //Value=>Description
        return array(
            1 => 'ACE 1',
            2 => 'ACE 2',
            3 => 'ACE 3',
            4 => 'ACE 4',
            5 => 'ACE 5',
            6 => 'ACE 6',
            7 => 'ACE 7',
            8 => 'ACE 8',
            9 => 'ACE 9',
            10 => 'ACE 10',
        );
    }

    public static function getPossibleCampuses()
    {
        //Value=>Description
        return array(
            'UNL' => 'University of Nebraska Lincoln',
            'UNO' => 'University of Nebraska Omaha',
            'UNMC' => 'University of Nebraska Medical University',
            'UNK' => 'University of Nebraska Kearney',
        );
    }

    public static function getPossibleDeliveryMethods()
    {
        //Value=>Description
        return array(
            'Classroom'      => 'Classroom',
            'Web'            => 'Online',
            'Correspondence' => 'Correspondence',
        );
    }

    public static function getPossibleTermsOffered()
    {
        //Value=>Description
        return array(
            'Fall'   => 'Fall',
            'Spring' => 'Spring',
            'Summer' => 'Summer',
        );
    }
}
