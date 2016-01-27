<?php

namespace UNL\UndergraduateBulletin\Developers;

class SubjectArea extends AbstractAction
{
    public $title = "Subject Area";

    public $uri = "courses/{subjectArea}";

    public $exampleURI = "courses/ECON";

    public $properties = [
        ["courses", "(Array) The courses", true, true],
    ];
}
