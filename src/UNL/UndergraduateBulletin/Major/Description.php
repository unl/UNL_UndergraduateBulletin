<?php
class UNL_UndergraduateBulletin_Major_Description
{
    protected static $epub_files = array(
        'CRIM and CRIM JUS' => 'Criminology and Criminal Justice',
        'Agribusiness'      => 'Agribusiness (College of Agricultural Sciences and Natural Resources)',
        'Agribusiness CBA'  => 'Agribusiness (College of Business Administration)'
    );
    
    /**
     * The major associated with this description
     * @var UNL_UndergraduateBulletin_Major
     */
    public $major;
    
    public $degrees_offered = array();
    
    public $hours_required;
    
    public $minor_available;
    
    public $minor_only;
    
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
        $file = self::getEpubFileByName($title);
        $xhtml = file_get_contents($file);
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

        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::format($body[0]->asXML());
    }
    
    public function parseQuickPoints($simplexml)
    {
        
        $quickpoints = $simplexml->xpath('//default:p[@class="quick-points"]');

        while (list( , $quickpoint) = each($quickpoints)) {
            // Handle quickpoint
            if (isset($quickpoint->span)) {
                $point_desc = (string)$quickpoint->span;
            } else {
                $point_desc = (string)$quickpoint;
            }
            if (preg_match('/([A-Z\s]+)+:/', $point_desc, $matches)) {
                $value = trim(str_replace($matches[0], '', (string)$quickpoint));
                switch($matches[1]) {
                    case 'COLLEGE':
                        $value = str_replace(
                                    array('Hixson-Lied ', 'College of ', ' and '), 
                                    array('',             '',            ' & '), $value);
                        if ($value == 'CASNR') {
                            $value = 'Agricultural Sciences & Natural Resources';
                        }
                        $this->college = new UNL_UndergraduateBulletin_College(array('name'=>$value));
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
                    case 'CHIEF ADVISERS':
                        $this->chief_advisor = $value;
                        break;
                    case 'MINOR ONLY':
                        $this->minor_only = $value;
                        break;
                    default:
                        echo 'Unknown quickpoint '.$matches[0];
                }
            }
        }
    }
    
    static function getNameByFile($filename)
    {
        
        $filename = str_replace(array(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/', '.epub'), '', $filename);
        
        if (isset(self::$epub_files[$filename])) {
            return self::$epub_files[$filename];
        }
        return $filename;
    }
    
    static function getEpubFileByName($name)
    {
        if ($new = array_search($name, self::$epub_files)) {
            $name = $new;
        }
        
        $epub = UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/'.$name.'.epub';
        
        if (!file_exists($epub)) {
            throw new Exception('Sorry, no description exists for '.$name. ' in '.$epub);
        }
        
        if (file_exists('phar://'.$epub.'/OEBPS/'.str_replace(' ', '_', $name).'.xhtml')) {
            return 'phar://'.$epub.'/OEBPS/'.str_replace(' ', '_', $name).'.xhtml';
        }
        
        if ($new) {
            $name = preg_replace('/\s+[A-Z]+$/', '', $name);
            return 'phar://'.$epub.'/OEBPS/'.str_replace(' ', '_', $name).'.xhtml';
        }
    }
}
?>