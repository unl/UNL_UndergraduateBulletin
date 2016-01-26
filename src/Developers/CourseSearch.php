<?php

namespace UNL\UndergraduateBulletin\Developers;

class CourseSearch extends AbstractAction
{
    public $title = "Course Search Results";

    public $uri = "courses/search/?q={search query}";

    public $exampleURI = "courses/search/?q=fish";
}
