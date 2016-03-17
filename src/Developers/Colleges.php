<?php

namespace UNL\UndergraduateBulletin\Developers;

class Colleges extends AbstractAction
{
    protected $title = 'Colleges';

    protected $uri = 'college';

    protected $exampleURI = 'college';

    protected $properties = [
        ['abbreviation', '(String) The abbreviation of the college'],
        ['name', '(String) The college name'],
        ['uri', '(String) URI to the college'],
    ];

    protected $formats = [
        'json',
        'partial'
    ];
}
