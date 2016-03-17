<?php

namespace UNL\UndergraduateBulletin\Developers;

class SubjectArea extends AbstractAction
{
    protected $title = 'Subject Area';

    protected $uri = 'courses/{subjectArea}';

    protected $exampleURI = 'courses/ECON';

    protected $properties = [
        ['courses', '(Array) The courses'],
    ];
}
