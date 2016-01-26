<?php

namespace UNL\UndergraduateBulletin\Developers;

class CollegeMajors extends AbstractAction
{
    public $title = "Majors for a Specific College";

    public $uri = "college/{collegeName}/majors";

    public $exampleURI = "college/Engineering/majors";

    public $formats = [
        'json',
        'partial'
    ];
}
