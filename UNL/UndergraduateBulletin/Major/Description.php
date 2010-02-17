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
        $file = dirname(dirname(dirname(dirname(__FILE__)))).'/data/majors/'.$title.'.epub';
        if (!file_exists($file)) {
            throw new Exception('Sorry, no description exists for '.$major->title);
        }
        $xhtml = file_get_contents('phar://'.$file.'/OEBPS/'.$title.'.xhtml');
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
        
    }
    
    public function parseQuickPoints($simplexml)
    {
        
        $quickpoints = $simplexml->xpath('//default:p[@class="quick-points"]');

        while (list( , $quickpoint) = each($quickpoints)) {
            // Handle quickpoint
            if (preg_match('/([A-Z\s]+)+:/', $quickpoint, $matches)) {
                $value = trim(substr($quickpoint, strlen($matches[1])+1));
                switch($matches[1]) {
                    case 'COLLEGE':
                        $this->college = new UNL_UndergraduateBulletin_College($value);
                        break;
                    case 'MAJOR':
                        break;
                    case 'DEGREE OFFERED':
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
    
    static function getByName($name)
    {
        $major = new UNL_UndergraduateBulletin_Major();
        $description = new self();
        switch ($name) {
            case 'Geography':
            case 'Advertising':
            case 'SocialScience':
                include dirname(__FILE__).'/../../data/samples/'.$name.'.php';
                
                return $description;
        }
        throw new Exception('No major by that name.');
    }
}
?>