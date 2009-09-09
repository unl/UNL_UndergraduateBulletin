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