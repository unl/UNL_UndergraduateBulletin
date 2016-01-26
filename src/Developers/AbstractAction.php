<?php

namespace UNL\UndergraduateBulletin\Developers;

use UNL\UndergraduateBulletin\Controller;

abstract class AbstractAction
{
    public $uri = '';

    public $exampleURI  = '';

    public $formats = [
        'json',
        'xml',
        'partial'
    ];

    public $properties = [];

    public function __construct()
    {
        $this->uri = Controller::getURL($this->uri);
        $this->exampleURI = Controller::getURL($this->exampleURI);
    }
}
