<?php

namespace UNL\UndergraduateBulletin\Developers;

class SubjectArea extends AbstractAction
{
    public $title = "Subject Area";

    public $uri = "courses/{subjectArea}";

    public $exampleURI = "courses/ECON";

    public $properties = [
        ["id", "(String) The subject code", true, true],
        ["title", "(String) The title of the subject area", true, true],
        ["courses", "(Array) The courses", true, true],
    ];
}
