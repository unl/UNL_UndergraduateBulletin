<?php
class UNL_UndergraduateBulletin_Major_Description
{
    protected static $epub_files = array(
        'Agribusiness'                                  => 'Agribusiness (CASNR)',
        'Agribusiness CBA'                              => 'Agribusiness (CBA)',
        'Art Education K-12'                            => 'Art Education (K-12)',
        'Biology 7-12'                                  => 'Biology (7-12)',
        'Chemistry 7-12'                                => 'Chemistry (7-12)',
        'Child Development_Early Childhood Educ'        => 'Child Development & Early Childhood Education',
        'Child_Youth & Family Studies_Jour & Mass Comm' => 'Child, Youth & Family Studies (CEHS)',
        'CRIM and CRIM JUS'                             => 'Criminology and Criminal Justice',
        'Early Care and Education_Birth-K'              => 'Early Care & Education (Birth-Kindergarten)',
        'Earth Sciences 7-12'                           => 'Earth Sciences (7-12)',
        'Elem Ed K-6_Deaf or Hard of Hearing PreProf'   => 'Elementary Education (K-6) & Deaf or Hard of Hearing (Pre-Professional)',
        'Elementary Education K-6'                      => 'Elementary Education (K-6)',
        'Elem Ed_Mild Mod Disabilties K-6'              => 'Elementary Education & Mild Moderate Disabilities (K-6)',
        'English 7-12'                                  => 'English (7-12)',
        'Family and Consumer Science 7-12'              => 'Family & Consumer Science Education (7-12)',
        'French Education 7-12'                         => 'French Education (7-12)',
        'Hospitality Restaurant and Tourism Management' => 'Hospitality, Restaurant, & Tourism Management (CASNR)',
        'Hospitality_Restaurant and Tourism Management' => 'Hospitality, Restaurant & Tourism Management (CEHS)',
        'Journalism_Mass Comm _English 7-12'            => 'Journalism & Mass Communication & English (7-12)',
        'Language Arts 7-12'                            => 'Language Arts (7-12)',
        'Latin Education 7-12'                          => 'Latin Education (7-12)',
        'Marketing_Cooperative Education 7-12'          => 'Marketing, Cooperative Education (7-12)',
        'Mathematics 7-12'                              => 'Mathematics (7-12)',
        'Mild_Moderate Disabilities 7-12'               => 'Mild, Moderate Disabilities (7-12)',
        'Natural Science 7-12'                          => 'Natural Science (7-12)',
        'Nutrition_Exercise & Health Sciences'          => 'Nutrition, Exercise & Health Sciences',
        'Physics 7-12'                                  => 'Physics (7-12)',
        'Russian Education 7-12'                        => 'Russian Education (7-12)',
        'Social Science 7-12'                           => 'Social Science (7-12)',
        'Spanish Education 7-12'                        => 'Spanish Education (7-12)',
        'Speech & English 7-12'                         => 'Speech & English (7-12)',
        'Textiles_Clothing & Design & Jour & Mass Comm' => 'Textiles, Clothing & Design (CEHS)',
        'Theatre & English 7-12'                        => 'Theatre & English (7-12)',
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

        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::format($body[0]->children()->asXML());
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
                    case 'HOURS REQUIRED':
                    case 'MINOR AVAILABLE':
                    case 'CHIEF ADVISER':
                    case 'CHIEF ADVISERS':
                    case 'MINOR ONLY':
                    case 'DEPARTMENT':
                    case 'DEPARTMENTS':
                    case 'PROGRAM':
                    case 'DEGREE':
                        $attr = explode(' ', strtolower($matches[1]));
                        $attr = array_map('ucfirst', $attr);
                        $attr = implode(' ', $attr);
                        $this->quickpoints[$attr] = $value;
                        break;
                    case 'GPA REQUIRED':
                        $this->quickpoints['GPA Required'] = $value;
                        break;
                    case 'MINIMUM CUMULATIVE GPA':
                        $this->quickpoints['Minimum Cumulative GPA'] = $value;
                        break;
                    default:
                        throw new Exception('Unknown quickpoint '.$matches[0]);
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