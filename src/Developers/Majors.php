<?php

namespace UNL\UndergraduateBulletin\Developers;

class Majors extends AbstractAction
{
    protected $title = 'Majors';

    protected $uri = 'majors';

    protected $exampleURI = 'majors';

    protected $properties = [
        ['title', '(String) The major (or area of study) name'],
        ['minorAvailable', '(Boolean) If this area of study is available as a minor'],
        ['minorOnly', '(Boolean) If this area of study is only available as a minor'],
        ['college', '(String[]) A list of colleges that oversee this major'],
        ['uri', '(String) URI to the major'],
    ];

    protected $formats = [
        'json',
        'partial'
    ];
}
