<?php

namespace UNL\UndergraduateBulletin\Developers;

class Colleges extends AbstractAction
{
    public $title = "Colleges";

    public $uri = "college";

    public $exampleURI = "college";

    public $properties = [
        ["abbreviation", "(String) The abbreviation of the college", true, true],
        ["name", "(String) The college name", true, true],
        ["uri", "(String) URI to the college", true, true],
    ];

    public $formats = [
        'json',
        'partial'
    ];
}
