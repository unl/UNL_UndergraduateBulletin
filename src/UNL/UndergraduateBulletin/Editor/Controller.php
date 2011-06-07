<?php
class UNL_UndergraduateBulletin_Editor_Controller extends UNL_UndergraduateBulletin_LoginRequired implements UNL_UndergraduateBulletin_CacheableInterface, UNL_UndergraduateBulletin_PostRunReplacements
{
    public $output;

    public $options = array('view'=>'summaryform');

    protected $view_map = array(
        'summaryform'     => 'UNL_UndergraduateBulletin_Editor_MajorSummaryForm',
        );

    public function __postConstruct()
    {
        UNL_UndergraduateBulletin_Controller::setEdition(new UNL_UndergraduateBulletin_Edition(array('year'=>UNL_UndergraduateBulletin_Editions::$latest)));
    }

    function preRun()
    {
        
    }

    function run()
    {
        try {
            if (isset($this->view_map[$this->options['view']])) {
                $this->output[] = new $this->view_map[$this->options['view']]($this->options);
            } else {
                $this->output[] = new Exception('Sorry, that view does not exist.');
            }
        } catch(Exception $e) {
            $this->output[] = $e;
        }
    }

    function getCacheKey()
    {
        return false;
    }

    public static function setReplacementData($field, $value)
    {
        
    }

    function postRun($data)
    {
        return $data;
    }
}