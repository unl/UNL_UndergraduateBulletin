<?php

namespace UNL\UndergraduateBulletin\OtherArea;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;
use UNL\UndergraduateBulletin\EPUB\Utilities;

class OtherAreas extends \ArrayIterator implements CacheableInterface
{
    public $options = [];

    protected $preferredOrder =[
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
    ];

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;
        $otherareas = glob(Controller::getEdition()->getDataDir().'/other/*.xhtml');
        usort($otherareas, [$this, 'comparePages']);
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

    public function getCacheKey()
    {
        return 'otherlist';
    }

    public function run()
    {
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
    }

    public function current()
    {
        $name = Utilities::getNameByFile(parent::current());
        return new OtherArea(['name' => $name]);
    }
}
