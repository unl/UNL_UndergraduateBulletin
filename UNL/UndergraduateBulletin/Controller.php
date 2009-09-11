<?php
class UNL_UndergraduateBulletin_Controller implements UNL_UndergraduateBulletin_PostRunReplacements
{
    public $output;
    
    public $options = array('view'=>'index');
    
    protected $view_map = array(
        'index'   => 'displayIndex',
        'major'   => 'displayMajorDescription',
        'courses' => 'displayMajorSubjectAreas');
    
    protected static $replacement_data = array();
    
    function __construct($options = array())
    {
        $this->options = array_merge($this->options, $options);
        $this->run();
    }
    
    function run()
    {
        if (isset($this->view_map[$this->options['view']])) {
            $this->{$this->view_map[$this->options['view']]}();
        }
    }
    
    function displayIndex()
    {
        $this->output[] = new UNL_UndergraduateBulletin_Introduction();
    }
    
    function displayMajorDescription()
    {
        $major = UNL_UndergraduateBulletin_Major::getByName($this->options['name']);
        $this->output[] = $major;
        $this->output[] = $major->description;
    }
    
    function displayMajorSubjectAreas()
    {
        $major = UNL_UndergraduateBulletin_Major::getByName($this->options['name']);
        $this->output[] = $major;
        $this->output[] = $major->subjectareas;
    }
    
    public static function setReplacementData($field, $data)
    {
        self::$replacement_data[$field] = $data;
    }
    
    function postRun($data)
    {
        $scanned = new UNL_Templates_Scanner($data);
        
        if (isset(self::$replacement_data['doctitle'])) {
            $data = str_replace($scanned->doctitle,
                                '<title>'.self::$replacement_data['doctitle'].'</title>',
                                $data);
        }
        
        if (isset(self::$replacement_data['head'])) {
            $data = str_replace('</head>', self::$replacement_data['head'].'</head>', $data);
        }

        if (isset(self::$replacement_data['breadcrumbs'])) {
            $data = str_replace($scanned->breadcrumbs,
                                self::$replacement_data['breadcrumbs'],
                                $data);
        }
        
        return $data;
    }
}
?>