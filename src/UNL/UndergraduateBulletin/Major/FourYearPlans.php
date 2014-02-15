<?php
class UNL_UndergraduateBulletin_Major_FourYearPlans extends ArrayIterator
{
    /**
     * Title of the major
     *
     * @var string
     */
    public $title;

    public $options = array();
    
    function __construct($options = array())
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;

        $this->set($this->getPlanData());

        parent::__construct($this->concentrations);
    }

    function getPlanData()
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
        return UNL_UndergraduateBulletin_EPUB_Utilities::getFileByName($name, 'fouryearplans', 'json');
    }

    /**
     * Get the major associated with this plan
     *
     * @return UNL_UndergraduateBulletin_Major
     */
    public function getMajor()
    {
        return UNL_UndergraduateBulletin_Major::getByName($this->title);
    }

    function current()
    {
        return new UNL_UndergraduateBulletin_Major_FourYearPlan_Concentration(array('id'=>parent::current()));
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    protected function childObjectMap($key)
    {
        switch ($key) {
            case 'concentrations':
            case 'year':
                return 'UNL_UndergraduateBulletin_Major_FourYearPlan_' . ucfirst($key);
        }

        throw new Exception('unknown child object key');
    }
}