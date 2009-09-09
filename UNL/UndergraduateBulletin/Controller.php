<?php
class UNL_UndergraduateBulletin_Controller
{
    public $output;
    
    public $options = array('view'=>'index');
    
    protected $view_map = array(
        'index' => 'displayIndex',
        'major' => 'displayMajor');
    
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
    
    function displayMajor()
    {
        $this->output[] = UNL_UndergraduateBulletin_Major::getByName('Geography');
    }
    
}
?>