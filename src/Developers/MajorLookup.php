<?php

namespace UNL\UndergraduateBulletin\Developers;

class MajorLookup extends AbstractAction
{
    protected $title = 'Academic Plan Code Map';

    protected $uri = 'major/lookup';

    protected $exampleURI = 'major/lookup';

    protected $formats = [
        'json',
    ];
}
