<?php
class UNL_UndergraduateBulletin_Major_Description
{
    /**
     * The major associated with this description
     * @var UNL_UndergraduateBulletin_Major
     */
    public $major;
    
    /**
     * An associative array of quickpoints about this major.
     * 
     * @var array
     */
    public $quickpoints = array();
    
    public $description;
    
    /**
     * The college
     * @var UNL_UndergraduateBulletin_College
     */
    public $college;
    
    function __construct(UNL_UndergraduateBulletin_Major $major)
    {
        $this->major = $major;
        
        $this->parseEPUB($this->major->title);
    }
    
    function parseEPUB($title)
    {
        $file = self::getFileByName($title);
        
        if (!file_exists($file)) {
            throw new Exception('The file '.$file.' for '.$title.' does not exist.', 404);
        }
        
        if (!$xhtml = file_get_contents($file)) {
            throw new Exception('Could not open ' . $file, 404);
        }
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

        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::format($body[0]->children()->asXML());
    }
    
    public function parseQuickPoints($simplexml)
    {
        
        $quickpoints = $simplexml->xpath('//default:p[@class="quick-points"]');

        while (list( , $quickpoint) = each($quickpoints)) {
            // Handle quickpoint
            if (isset($quickpoint->span)) {
                $point_desc = (string)$quickpoint->span;
                if (count($quickpoint->span) == 2) {
                    $quickpoint = $quickpoint->span[1];
                }
            } else {
                $point_desc = (string)$quickpoint;
            }
            if (preg_match('/\s*([A-Z\s]+)+:/', $point_desc, $matches)) {
                $value = trim(str_replace($matches[0], '', (string)$quickpoint));
                $attr = $matches[1];
                switch($attr) {
                    case 'COLLEGE':
                        $value = str_replace(
                                    array('Hixson-Lied ', 'College of ', ' and '), 
                                    array('',             '',            ' & '), $value);
                        if ($value == 'CASNR') {
                            $value = 'Agricultural Sciences & Natural Resources';
                        }
                        $this->colleges = new UNL_UndergraduateBulletin_Major_Colleges(array('colleges' => $value));
                        break;
                    case 'MAJOR':
                        break;
                    case 'OFFERED';
                    case 'DEGREE OFFERED':
                    case 'DEGREES OFFERED':
                    case 'HOURS REQUIRED':
                    case 'MINOR AVAILABLE':
                    case 'CHIEF ADVISER':
                    case 'CHIEF ADVISERS':
                    case 'MINOR ONLY':
                    case 'DEPARTMENT':
                    case 'DEPARTMENTS':
                    case 'PROGRAM':
                    case 'DEGREE':
                    case 'ADVISERS':
                    case 'ADVISER':
                        $attr = explode(' ', strtolower($attr));
                        $attr = array_map('ucfirst', $attr);
                        $attr = implode(' ', $attr);
                        $this->quickpoints[$attr] = $value;
                        break;
                    case 'GPA':
                    case 'GPA REQUIRED':
                        $this->quickpoints['GPA Required'] = $value;
                        break;
                    case 'MINIMUM CUMULATIVE GPA':
                        $this->quickpoints['Minimum Cumulative GPA'] = $value;
                        break;
                    default:
                        throw new Exception('Unknown quickpoint "'.$matches[0].'"');
                }
            }
        }
    }

    static function getFileByName($name)
    {
        return UNL_UndergraduateBulletin_EPUB_Utilities::getFileByName($name, 'majors', 'xhtml');
    }

    static function setEpubToTitleMap($array)
    {
        UNL_UndergraduateBulletin_EPUB_Utilities::setEpubToTitleMap($array);
    }

    /**
     * Get the epub filename to title map
     * 
     * @return array Associative array of [filename]=>[title]
     */
    static function getEpubToTitleMap()
    {
        return UNL_UndergraduateBulletin_EPUB_Utilities::getEpubToTitleMap();
    }
}
