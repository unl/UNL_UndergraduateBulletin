<?php
class UNL_UndergraduateBulletin_Major_Description
{
    /**
     * The major associated with this description
     * @var UNL_UndergraduateBulletin_Major
     */
    public $major;
    
    public $degrees_offered = array();
    
    public $hours_required;
    
    public $minor_available;
    
    public $chief_advisor;
    
    public $description;
    
    public $admission;
    
    public $major_requirements;
    
    public $additional_major_requirements;
    
    public $college_degree_requirements;
    
    public $requirements_for_minor;
    
    public $ace_requirements;
    
    public $other;
    
    function __construct(UNL_UndergraduateBulletin_Major $major)
    {
        $this->major = $major;
    }
    
    static function getByName($name)
    {
        $major = new UNL_UndergraduateBulletin_Major();
        $description = new self();
        switch ($name) {
            case 'Geography':
            case 'Advertising':
            case 'SocialScience':
                include dirname(__FILE__).'/../../data/samples/'.$name.'.php';
                
                return $description;
        }
        throw new Exception('No major by that name.');
    }
}
?>