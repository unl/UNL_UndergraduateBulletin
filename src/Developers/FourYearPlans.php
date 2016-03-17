<?php

namespace UNL\UndergraduateBulletin\Developers;

class FourYearPlans extends AbstractAction
{
    protected $title = 'Major Four Year Plans';

    protected $uri = 'major/{major}/plans';

    protected $exampleURI = 'major/Actuarial+Science+%28ASC%29/plans';

    protected $formats = [
        'json',
        'partial'
    ];
}
