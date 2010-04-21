<?php
class UNL_UndergraduateBulletin_Controller implements UNL_UndergraduateBulletin_PostRunReplacements, UNL_UndergraduateBulletin_CacheableInterface
{
    /**
     * URL to this controller.
     *
     * @var string
     */
    public static $url = '';
    
    public $output;
    
    public $options = array('view'   => 'index', // The default from the view_map
                            'format' => 'html',  // The default output format
    );
    
    protected $view_map = array(
        'index'         => 'UNL_UndergraduateBulletin_Introduction',
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

        if (isset(self::$replacement_data['doctitle'])) {
            $data = preg_replace('/<title>.*<\/title>/',
                                '<title>'.self::$replacement_data['doctitle'].'</title>',
                                $data);
        }
        
        if (isset(self::$replacement_data['head'])) {
            $data = str_replace('</head>', self::$replacement_data['head'].'</head>', $data);
        }

        if (isset(self::$replacement_data['breadcrumbs'])
            && strstr($data, '<!-- InstanceBeginEditable name="breadcrumbs" -->')) {

            $start = strpos($data, '<!-- InstanceBeginEditable name="breadcrumbs" -->')+strlen('<!-- InstanceBeginEditable name="breadcrumbs" -->');
            $end = strpos($data, '<!-- InstanceEndEditable -->', $start);

            $data = substr($data, 0, $start).self::$replacement_data['breadcrumbs'].substr($data, $end);
        }

        if (isset(self::$replacement_data['pagetitle'])
            && strstr($data, '<!-- InstanceBeginEditable name="pagetitle" -->')) {

            $start = strpos($data, '<!-- InstanceBeginEditable name="pagetitle" -->')+strlen('<!-- InstanceBeginEditable name="pagetitle" -->');
            $end = strpos($data, '<!-- InstanceEndEditable -->', $start);

            $data = substr($data, 0, $start).self::$replacement_data['pagetitle'].substr($data, $end);
            
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
        
        if (is_object($mixed)) {
            switch (get_class($mixed)) {
            
            default:
                    
            }
        }
        
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
}
?>