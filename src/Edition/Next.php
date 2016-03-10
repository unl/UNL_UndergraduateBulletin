<?php

namespace UNL\UndergraduateBulletin\Edition;

use UNL\UndergraduateBulletin\CatalogController;

/**
 * This edition is slightly unique. COURSE data is pulled from the NEXT edition.
 * This folder is what will be used to cut a new yearly edition
 *
 */
class Next extends Edition
{
    public function __construct($options = [])
    {
        $options['year'] = 'next';
        parent::__construct($options);
    }

    public function getRange()
    {
        return 'Next Edition';
    }

    public function getURL()
    {
        return CatalogController::getBaseURL();
    }
}
