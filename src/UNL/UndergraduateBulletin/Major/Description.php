<?php
class UNL_UndergraduateBulletin_Major_Description
{
    /**
     * The major associated with this description
     * @var UNL_UndergraduateBulletin_Major
     */
    public $major;
    
    public $degrees_offered = array();
    
    public $hours_required;
    
    public $minor_available;
    
    public $chief_advisor;
    
    public $description;
    
    public $college;
    
    function __construct(UNL_UndergraduateBulletin_Major $major)
    {
        $this->major = $major;
        
        $this->parseEPUB($this->major->title);
    }
    
    function parseEPUB($title)
    {
        $file = UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/'.$title.'.epub';
        if (!file_exists($file)) {
            throw new Exception('Sorry, no description exists for '.$title. ' in '.$file);
        }
        $xhtml = file_get_contents('phar://'.$file.'/OEBPS/'.str_replace(' ', '_', $title).'.xhtml');
        $simplexml = simplexml_load_string($xhtml);
        
        // Fetch all namespaces
        $namespaces = $simplexml->getNamespaces(true);
        $simplexml->registerXPathNamespace('default', $namespaces['']);
        
        // Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $simplexml->registerXPathNamespace($prefix, $ns);
        }

        $this->parseQuickPoints($simplexml);

        $body = $simplexml->xpath('//default:body');

        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($body[0]->asXML());
        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($this->description);
        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::addCourseLinks($this->description); 
        
    }
    
    public function parseQuickPoints($simplexml)
    {
        
        $quickpoints = $simplexml->xpath('//default:p[@class="quick-points"]');

        while (list( , $quickpoint) = each($quickpoints)) {
            // Handle quickpoint
            if (preg_match('/([A-Z\s]+)+:/', (string)$quickpoint->span, $matches)) {
                $value = trim((string)$quickpoint);
                switch($matches[1]) {
                    case 'COLLEGE':
                        $this->college = new UNL_UndergraduateBulletin_College($value);
                        break;
                    case 'MAJOR':
                        break;
                    case 'DEGREE OFFERED':
                    case 'DEGREES OFFERED':
                        $this->degrees_offered[] = $value;
                        break;
                    case 'HOURS REQUIRED':
                        $this->hours_required = $value;
                        break;
                    case 'MINOR AVAILABLE':
                        $this->minor_available = $value;
                        break;
                    case 'CHIEF ADVISER':
                        $this->chief_advisor = $value;
                        break;
                    default:
                        echo 'Unknown quickpoint '.$matches[0];
                }
            }
        }
    }
}
?>