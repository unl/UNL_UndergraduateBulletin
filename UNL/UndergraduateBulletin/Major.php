<?php
class UNL_UndergraduateBulletin_Major
{
    public $title;
    
    public $college;
    
    public $degrees_offered;
    
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
    
    static function getByName($name)
    {
        $major = new self();
        switch ($name) {
            case 'Geography':
                include dirname(__FILE__).'/../../data/samples/'.$name.'.php';
                
                return $major;
        }
        throw new Exception('No major by that name.');
    }
}
?>