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
    
    function __construct(UNL_UndergraduateBulletin_Major $major)
    {
        $this->major = $major;
        
        $this->parseEPUB($this->major->title);
    }
    
    function parseEPUB($title)
    {
        $file = dirname(dirname(dirname(dirname(__FILE__)))).'/data/majors/'.$title.'.epub';
        if (!file_exists($file)) {
            throw new Exception('Sorry, no description exists for '.$major->title);
        }
        $xhtml = file_get_contents('phar://'.$file.'/OEBPS/'.$title.'.xhtml');
        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($xhtml);
        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($this->description);
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