<?php
class UNL_UndergraduateBulletin_Controller implements UNL_UndergraduateBulletin_PostRunReplacements, UNL_UndergraduateBulletin_CacheableInterface
{
    /**
     * URL to this controller.
     *
     * @var string
     */
    public static $url = '';
    
    public static $newest_url = 'http://bulletin.unl.edu/undergraduate/';
    
    public $output;
    
    private static $editions_checked = false;
    
    public $options = array('view'   => 'index', // The default from the view_map
                            'format' => 'html',  // The default output format
    );
    
    protected $view_map = array(
        'index'         => 'UNL_UndergraduateBulletin_Introduction',
        'about'         => 'UNL_UndergraduateBulletin_About',
        'general'       => 'UNL_UndergraduateBulletin_GeneralInformation',
        'majors'        => 'UNL_UndergraduateBulletin_MajorList',
        'major'         => 'UNL_UndergraduateBulletin_Major',
        'courses'       => 'UNL_UndergraduateBulletin_Major',
        'subject'       => 'UNL_UndergraduateBulletin_SubjectArea',
        'subjects'      => 'UNL_UndergraduateBulletin_SubjectAreas',
        'course'        => 'UNL_UndergraduateBulletin_Listing',
        'college'       => 'UNL_UndergraduateBulletin_College',
        'colleges'      => 'UNL_UndergraduateBulletin_CollegeList',
        'searchcourses' => 'UNL_UndergraduateBulletin_CourseSearch',
        'searchmajors'  => 'UNL_UndergraduateBulletin_MajorSearch',
        'search'        => 'UNL_UndergraduateBulletin_Search',
        'bulletinrules' => 'UNL_UndergraduateBulletin_BulletinRules',
        'editions'      => 'UNL_UndergraduateBulletin_Editions',
        );
    
    protected static $replacement_data = array();
    
    function __construct($options = array())
    {
        $this->options = array_merge($this->options, $options);
    }
    
    function getCacheKey()
    {
        return serialize($this->options);
    }
    
    function preRun()
    {
        
    }
    
    function run()
    {
        try {
            switch($this->options['format']) {
            case 'partial':
                UNL_UndergraduateBulletin_ClassToTemplateMapper::$output_template[__CLASS__] = 'Controller-partial';
            case 'html':
            default:
                // Standard template works for html.
                
                break;
            }
            if (isset($this->view_map[$this->options['view']])) {
                $this->output[] = new $this->view_map[$this->options['view']]($this->options);
            } else {
                $this->output[] = new Exception('Sorry, that view does not exist.');
            }
        } catch(Exception $e) {
            $this->output[] = $e;
        }
    }
    
    public static function setReplacementData($field, $data)
    {
        self::$replacement_data[$field] = $data;
    }
    
    function postRun($data)
    {

        if (isset(self::$replacement_data['doctitle'])
            && strstr($data, '<title>')) {
            $data = preg_replace('/<title>.*<\/title>/',
                                '<title>'.self::$replacement_data['doctitle'].'</title>',
                                $data);
            unset(self::$replacement_data['doctitle']);
        }

        if (isset(self::$replacement_data['head'])
            && strstr($data, '</head>')) {
            $data = str_replace('</head>', self::$replacement_data['head'].'</head>', $data);
            unset(self::$replacement_data['head']);
        }

        if (isset(self::$replacement_data['breadcrumbs'])
            && strstr($data, '<!-- InstanceBeginEditable name="breadcrumbs" -->')) {

            $start = strpos($data, '<!-- InstanceBeginEditable name="breadcrumbs" -->')+strlen('<!-- InstanceBeginEditable name="breadcrumbs" -->');
            $end = strpos($data, '<!-- InstanceEndEditable -->', $start);

            $data = substr($data, 0, $start).self::$replacement_data['breadcrumbs'].substr($data, $end);
            unset(self::$replacement_data['breadcrumbs']);
        }

        if (isset(self::$replacement_data['pagetitle'])
            && strstr($data, '<!-- InstanceBeginEditable name="pagetitle" -->')) {

            $start = strpos($data, '<!-- InstanceBeginEditable name="pagetitle" -->')+strlen('<!-- InstanceBeginEditable name="pagetitle" -->');
            $end = strpos($data, '<!-- InstanceEndEditable -->', $start);

            $data = substr($data, 0, $start).self::$replacement_data['pagetitle'].substr($data, $end);
            unset(self::$replacement_data['pagetitle']);
        }
        return $data;
    }
    
    /**
     * Get the URL for the system or a specific object this controller can display.
     *
     * @param mixed $mixed             Optional object to get a URL for.
     * @param array $additional_params Extra parameters to adjust the URL.
     * 
     * @return string
     */
    static function getURL($mixed = null, $additional_params = array())
    {
        $params = array();
         
        $url = self::$url;

        $params = array_merge($params, $additional_params);
        
        $url .= '?';
        
        foreach ($params as $option=>$value) {
            if (!empty($value)) {
                $url .= "&amp;$option=$value";
            }
        }
        
        return trim($url, '?;=');
    }
    
    static function getDataDir()
    {
        return dirname(dirname(dirname(dirname(__FILE__)))).'/data';
    }
    
    /**
     * Determine if the current url is out of date.
     * 
     * @return bool True if out of date, False if newest.
     */
    static function isArchived()
    {
        return !(self::$url == parse_url(self::$newest_url, PHP_URL_PATH));
    }
    
    /**
     * Get the request uri for the current selected page and compile a URL to the
     * Newest URL with the same request uri.
     * 
     * @return string. The url to the newest version.
     */
    static function getNewestURL()
    {
        $request = explode(self::$url, $_SERVER['REQUEST_URI']);
        if (isset($request[1])) {
            $newestURL = self::$newest_url . $request[1];
        } else {
            $newestURL = self::$newest_url;
        }
        return $newestURL;
    }
    
    /**
     * Gets the version of the bulletin.  Version = year in the url.
     * 
     * @return int.. The year of the bulletin.  False if no year.
     */
    static function getEdition()
    {
        $editions = self::getAllEditions();
        //Format the current url so that it is the same format as the editions url.
        $url = "http://".$_SERVER['SERVER_NAME'].self::$url;
        
        //check it to make sure its a year.
        if ($year = array_search($url, $editions)) {
            // Matching year was found, return it
            return $year;
        }
        return false;
    }
    
    /**
     * Gets an array of all the editions from the latest edition.
     * 
     * @return array.. The list of editions.
     */
    static function getAllEditions()
    {
        //Only try to get the editions array once.
        if(!self::$editions_checked){
            if (self::isArchived()) {
                //edition is not newest, call the newest for the complete list of editions.
                if ($json = @file_get_contents(self::$newest_url.'editions/?format=json')) {
                    UNL_UndergraduateBulletin_Editions::$editions = json_decode($json, true);
                }
            }
            //edition is the newest, use our own list of editions.
        }
        self::$editions_checked = true;
        return UNL_UndergraduateBulletin_Editions::$editions;
    }
}
