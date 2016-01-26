<?php

namespace UNL\UndergraduateBulletin\Developers;

class Course extends AbstractAction
{
    public $title = "Course";

    public $uri = "courses/{subjectArea}/{course number}";

    public $exampleURI = "courses/ECON/211";

    public $properties = [
        ["title", "(String) The title of the course", true, true],
        ["description", "(String) The course description", true, true],
        ["prerequisite", "(String) The prerequisite for joining the course", true, true],
        ["courseCodes", "(String) A list of the course codes belonging to the course.", true, true],
        ["gradingType", "(String) The gradingType of the course.", false, true],
        ["dfRemoval", "(bool) D or F removal", false, true],
        ["effectiveSemester", "(int) The effective semester of the course.", false, true],
        ["notes", "(String) Notes about the course.", false, true],
        ["campus", "(String) The campus that the course is located at.", false, true],
        ["deliveryMethods", "(String) A list of delivery methods for the course.", false, true],
        ["termsOffered", "(String) a list of terms that the course is avaibale during.", false, true],
        ["activities", "(String) A list of activites for the course, ie: lecture and recitation.", false, true],
        ["credits", "(int) The credits that the course is worth.", false, true],
        ["aceOutcomes", "(int) a list of ace outcomes for the course.", false, true],
    ];
}
