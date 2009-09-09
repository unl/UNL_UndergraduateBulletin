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
    
    static function getByName($name)
    {
        $major = new self();
        switch ($name) {
            case 'Geography':
                include dirname(__FILE__).'/../../data/samples/'.$name.'.php';
                $major->title = 'Geography';
                $major->college = 'Arts & Sciences';
                $major->hours_required = 120;
                $major->minor_available = true;
                $major->chief_advisor = 'bbieber2';
                $major->description = '';
                return $major;
        }
        throw new Exception('No major by that name.');
    }
}
?>