<?php
class UNL_UndergraduateBulletin_OtherAreas extends ArrayIterator  implements UNL_UndergraduateBulletin_CacheableInterface
{
    public $options = array('format'=>'html');
    
    protected $preferredOrder = array(
        'Academic Policies & Procedures.xhtml' => 2,
        'Admissions.xhtml' => 0,
        'Aerospace Studies_Air Force ROTC.xhtml' => 8,
        'General Education Requirements (ACE).xhtml' => 3,
        'Graduate Studies.xhtml' => 6,
        'Jeffrey S. Raikes School of Computer Science & Management.xhtml' => 5,
        'Military Science_Army ROTC.xhtml' => 9,
        'Naval Science_Naval ROTC.xhtml' => 10,
        'Pre-Professional Studies.xhtml' => 7,
        'The Libraries.xhtml' => 11,
        'Transfer.xhtml' => 1,
        'University Honors Program.xhtml' => 4,
    );

    function __construct($options = array())
    {
        $this->options = $options + $this->options;
        $otherareas = glob(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/other/*.xhtml');
        usort($otherareas, array($this, 'comparePages'));
        return parent::__construct($otherareas);
    }
    
    protected function comparePages($a, $b)
    {
        $a = basename($a);
        $b = basename($b);
        $aSort = isset($this->preferredOrder[$a]) ? $this->preferredOrder[$a] : 999;
        $bSort = isset($this->preferredOrder[$b]) ? $this->preferredOrder[$b] : 999;
        
        if ($aSort == $bSort) {
            return 0;
        }
        
        return $aSort < $bSort ? -1 : 1;
    }

    function getCacheKey()
    {
        return 'otherlist'.$this->options['format'];
    }

    function run()
    {
        
    }

    function preRun($fromCache, Savvy $savvy)
    {
        
    }

    function current()
    {
        $name = UNL_UndergraduateBulletin_EPUB_Utilities::getNameByFile(parent::current());

        return new UNL_UndergraduateBulletin_OtherArea(array('name'=>$name));
    }
}
