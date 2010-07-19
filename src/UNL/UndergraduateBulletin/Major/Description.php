<?php
class UNL_UndergraduateBulletin_Major_Description
{
    protected static $epub_files = array(
        // data/majors/{FILENAME}.xhtml                 => title displayed
        'African_American_African Studies Minor'        => 'African-American Studies; African Studies Minor (ASC)',
        'Child Development_Early Childhood Educ'        => 'Child Development/Early Childhood Education',
        'Child, Youth & Family Studies (CEHS)'          => 'Child, Youth & Family Studies/Journalism & Mass Communications (CEHS)',
        'Elem Ed_Early Childhood (Birth-6)'             => 'Elementary Education/Early Childhood (Birth to 6 grade)',
        'Elem Ed K-6_Deaf or Hard of Hearing PreProf'   => 'Elementary Education (K-6) & Deaf or Hard of Hearing (Pre-Professional)',
        'Hospitality Restaurant and Tourism Management' => 'Hospitality, Restaurant, & Tourism Management (CASNR)',
        'Hospitality_Restaurant & Tourism Management'   => 'Hospitality, Restaurant & Tourism Management (CEHS)',
        'Human Rights_Human Diversity Minor'            => 'Human Rights & Human Diversity (Minor only)',
        'LGBTQ Sexuality Studies Minor'                 => 'Lesbian, Gay, Bisexual, Transgender, Queer/Sexuality Studies (Minor only)',
        'Mild_Moderate Disabilities (7-12)'             => 'Mild/Moderate Disabilities (7-12)',
        'Modern Languages-French German & Russian Minor (ENGR)' => 'Modern Languages-French, German & Russian Minor (ENGR)',
        'PreHealth_PreLaw & Combined Degree Prog'       => 'Pre-Health, Pre-Law and Combined Degree Programs',
        'Public Policy Analysis_Program Eval Cert'      => 'Public Policy Analysis & Program Evaluation Certification',
        'Textiles_Clothing & Design & Jour & Mass Comm' => 'Textiles, Clothing & Design/Journalism & Mass Communications (CEHS)',
        'Textiles_Clothing_Design Minor (ASC)'          => 'Textiles, Clothing, & Design Minor (ASC)',
        'Womens_Gender Studies'                         => 'Women\'s & Gender Studies',
    );
    
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
            throw new Exception('The file '.$file.' for '.$title.' does not exist.');
        }
        
        if (!$xhtml = file_get_contents($file)) {
            throw new Exception('Could not open ' . $file);
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
                        $this->college = new UNL_UndergraduateBulletin_College(array('name'=>$value));
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
    
    static function getNameByFile($filename)
    {
        
        $filename = str_replace(array(UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/', '.xhtml'), '', $filename);
        
        if (isset(self::$epub_files[$filename])) {
            return self::$epub_files[$filename];
        }
        return $filename;
    }
    
    static function getFileByName($name)
    {
        if ($new = array_search($name, self::$epub_files)) {
            $name = $new;
        }

        $xhtml = UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/'.$name.'.xhtml';

        if (!file_exists($xhtml)) {
            throw new Exception('Sorry, no description exists for '.$name. ' in '.$xhtml);
        }

        return $xhtml;
    }
}
