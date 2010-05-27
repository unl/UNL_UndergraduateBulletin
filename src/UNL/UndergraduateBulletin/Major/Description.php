<?php
class UNL_UndergraduateBulletin_Major_Description
{
    protected static $epub_files = array(
        // data/majors/{FILENAME}.epub                  => title displayed
        'Actuarial Science'                             => 'Actuarial Science (CBA)',
        'African_American_African Studies Minor'        => 'African-American Studies; African Studies (ASC)',
        'Agribusiness'                                  => 'Agribusiness (CASNR)',
        'Agribusiness CBA'                              => 'Agribusiness (CBA)',
        'Art (K-12)'                                    => 'Art Education (K-12)',
        'Business_Coop Educ (7-12)'                     => 'Business/Cooperative Education (Grades 7-12)',
        'Child Development_Early Childhood Educ'        => 'Child Development/Early Childhood Education',
        'Child_Youth & Family Studies_Jour & Mass Comm' => 'Child, Youth & Family Studies (CEHS)',
        'CRIM and CRIM JUS'                             => 'Criminology and Criminal Justice',
        'Early Care and Education (Birth-K)'            => 'Early Care & Education (Birth-Kindergarten)',
        'Earth Science (7-12)'                          => 'Earth Sciences (7-12)',
        'Economics'                                     => 'Economics (CBA)',
        'Elem Ed_Early Childhood (Birth-6)'             => 'Elementary Education/Early Childhood (Birth to 6 grade)',
        'Elem Ed K-6_Deaf or Hard of Hearing PreProf'   => 'Elementary Education (K-6) & Deaf or Hard of Hearing (Pre-Professional)',
        'Elem Ed_Mild Mod Disabilties (K-6)'            => 'Elementary Education & Mild Moderate Disabilities (K-6)',
        'Environmental Studies'                         => 'Environmental Studies (CASNR)',
        'Family & Consumer Science (7-12)'              => 'Family & Consumer Science Education (7-12)',
        'French (7-12)'                                 => 'French Education (7-12)',
        'German (7-12)'                                 => 'German Education (7-12)',
        'Hospitality Restaurant and Tourism Management' => 'Hospitality, Restaurant, & Tourism Management (CASNR)',
        'Hospitality_Restaurant & Tourism Management'   => 'Hospitality, Restaurant & Tourism Management (CEHS)',
        'Human Rights_Human Diversity Minor'            => 'Human Rights & Human Diversity (Minor only)',
        'Inclusive Early Childhood Ed (B-3rd Gr)'       => 'Inclusive Early Childhood Education (Birth-3rd grade)',
        'Industrial_Management Systems Engr'            => 'Industrial & Management Systems Engineering',
        'Jour & Mass Comm & English (7-12)'             => 'Journalism & Mass Communication & English (7-12)',
        'Language Arts 7-12'                            => 'Language Arts (7-12)',
        'Latin Education 7-12'                          => 'Latin Education (7-12)',
        'LGBTQ Sexuality Studies Minor'                 => 'Lesbian, Gay, Bisexual, Transgender, Queer/Sexuality Studies (Minor only)',
        'Marketing_Cooperative Education 7-12'          => 'Marketing, Cooperative Education (7-12)',
        'Mathematics 7-12'                              => 'Mathematics (7-12)',
        'Meteorology_Climatology'                       => 'Meteorology-Climatology',
        'Mild_Moderate Disabilities 7-12'               => 'Mild/Moderate Disabilities (Grades 7-12)',
        'Modern Languages_Literatures'                  => 'Modern Languages & Literatures',
        'Natural Science 7-12'                          => 'Natural Science (7-12)',
        'Nutrition_Exercise & Health Sciences'          => 'Nutrition, Exercise & Health Sciences',
        'Physics 7-12'                                  => 'Physics (7-12)',
        'Plant Biology'                                 => 'Plant Biology (CASNR)',
        'Plant Biology (ASC)'                           => 'Plant Biology (ASC)',
        'PreHealth_PreLaw & Combined Degree Prog'       => 'Pre-Health, Pre-Law and Combined Degree Programs',
        'Public Policy Analysis_Program Eval Cert'      => 'Public Policy Analysis & Program Evaluation Certification',
        'Russian Education 7-12'                        => 'Russian Education (7-12)',
        'Social Science 7-12'                           => 'Social Science (7-12)',
        'Spanish Education 7-12'                        => 'Spanish Education (7-12)',
        'Speech & English 7-12'                         => 'Speech & English (7-12)',
        'Speech Language Pathology_Audiology'           => 'Speech Language Pathology & Audiology',
        'Textiles_Clothing & Design & Jour & Mass Comm' => 'Textiles, Clothing & Design (CEHS)',
        'Textiles_Clothing_Design Minor (ASC)'          => 'Textiles, Clothing, & Design Minor (ASC)',
        'Theatre & English 7-12'                        => 'Theatre & English (7-12)',
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
        $file = self::getEpubFileByName($title);
        
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

        $epub_map = json_decode(file_get_contents(UNL_UndergraduateBulletin_Controller::getDataDir().'/major_epubs.json'));

        $epub = UNL_UndergraduateBulletin_Controller::getDataDir().'/majors/'.$name.'.epub';

        if (!
            (file_exists($epub) && isset($epub_map->{$name.'.epub'}))) {
            throw new Exception('Sorry, no description exists for '.$name. ' in '.$epub);
        }

        return 'phar://'.$epub.'/OEBPS/'.$epub_map->{$name.'.epub'};
    }
}
