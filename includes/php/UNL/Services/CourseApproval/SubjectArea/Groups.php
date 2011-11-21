<?php
class UNL_Services_CourseApproval_SubjectArea_Groups implements Countable
{
    /**
     * The XCRI as a SimpleXMLElement
     * 
     * @var SimpleXMLElement
     */
    public $groups = array();
    
    /**
     * subject area
     * 
     * @var UNL_Services_CourseApproval_SubjectArea
     */
    protected $_subjectArea;
    
    function __construct(UNL_Services_CourseApproval_SubjectArea $subjectarea)
    {
        $this->_subjectArea = $subjectarea;
        $this->_xcri = new SimpleXMLElement(UNL_Services_CourseApproval::getXCRIService()->getSubjectArea($subjectarea->subject));
        
        //Fetch all namespaces
        $namespaces = $this->_xcri->getNamespaces(true);
        $this->_xcri->registerXPathNamespace('default', $namespaces['']);
        
        //Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $this->_xcri->registerXPathNamespace($prefix, $ns);
        }
        
        $xpath = "//default:subject[.='{$subjectarea->subject}']/../default:courseGroup";
        $groups = $this->_xcri->xpath($xpath);
        if ($groups) {
            foreach ($groups as $group) {
                $this->groups[] = (string)$group;
            }
            
            $this->groups = array_unique($this->groups);
            asort($this->groups);
        }
    }
    
    function count()
    {
        return count($this->groups);
    }
}
