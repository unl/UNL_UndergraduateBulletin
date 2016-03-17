<?php

namespace UNL\UndergraduateBulletin\Developers;

class SubjectAreas extends AbstractAction
{
    protected $title = 'Subject Areas';

    protected $uri = 'courses';

    protected $exampleURI = 'courses';

    protected $properties = [
        ['href', '(String) URI to the major'],
        ['title', '(String) The name of the subject'],
    ];

    protected $formats = [
        'json',
        'partial'
    ];
}
