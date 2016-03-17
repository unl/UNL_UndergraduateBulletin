<?php

namespace UNL\UndergraduateBulletin\Developers;

class Outcomes extends AbstractAction
{
    protected $title = 'Major Outcomes';

    protected $uri = 'major/{major}/outcomes';

    protected $exampleURI = 'major/Actuarial+Science+%28ASC%29/outcomes';

    protected $formats = [
        'json',
        'partial'
    ];
}
