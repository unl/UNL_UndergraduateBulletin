<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;
use UNL\UndergraduateBulletin\EPUB\Utilities;

class Majors extends \ArrayIterator implements
    CacheableInterface,
    ControllerAwareInterface
{
    protected $controller;

    public $options = [];

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;
        $majors = glob(Controller::getEdition()->getDataDir() . '/majors/*.xhtml');
        return parent::__construct($majors);
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getCacheKey()
    {
        return 'majorlist' . $this->options['format'];
    }

    public function run()
    {
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
        $controller = $this->getController();
        $controller::setReplacementData('doctitle', 'Majors/Areas of Study'
            . ' | Undergraduate Bulletin | University of Nebraska-Lincoln');

        $pagetitle = '<h1>Majors/Areas of Study</h1>';
        $controller::setReplacementData('pagetitle', $pagetitle);

        $controller::setReplacementData('breadcrumbs', <<<EOD
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="{$controller::getURL()}">Undergraduate Bulletin</a></li>
    <li>Majors/Areas of Study</li>
</ul>
EOD
        );
    }

    public function current()
    {

        $name = Utilities::getNameByFile(parent::current());
        return new Major(['name' => $name]);
    }
}
