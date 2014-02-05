<?php
class UNL_UndergraduateBulletin_Major_LearningOutcomes extends ArrayIterator
{
    /**
     * Title of the major
     *
     * @var string
     */
    public $title;

    public $options = array();
    
    public function __construct($options = array())
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;

        $this->set($this->getOutcomeData());

        parent::__construct($this->concentrations);
    }

    public function getOutcomeData()
    {
        $file = self::getFileByName($this->title);
        $data = array();

        if ($json = file_get_contents($file)) {
            $data = json_decode($json, true);
        }

        return $data;
    }

    static function getFileByName($name)
    {
        if ($new = array_search($name, UNL_UndergraduateBulletin_Major_Description::getEpubToTitleMap())) {
            $name = $new;
        }

        $json = UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/outcomes/'.$name.'.json';

        if (!file_exists($json)) {
            throw new Exception('Sorry, no learning outcome data exists for '.$name, 404);
        }

        return $json;
    }
    

    public function current()
    {
        return new UNL_UndergraduateBulletin_Major_LearningOutcome_Concentration(array('id'=>parent::current()));
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
