<?php

namespace UNL\UndergraduateBulletin\Developers;

class FourYearPlans extends AbstractAction
{
    public $title = "Four Year Plans";

    public $uri = "major/{major}/plans";

    public $exampleURI = "major/Actuarial+Science+%28ASC%29/plans";

    public $formats = [
        'json',
        'partial'
    ];
}
