<?php

namespace UNL\UndergraduateBulletin\Editions;

use UNL\UndergraduateBulletin\Controller;

/**
 * This edition is slightly unique. COURSE data is pulled from the NEXT edition.
 *
 * For example, during academic year 2010-2011 course data will be pulled from
 * the (unfinalized) 2011-2012 edition. This allows the latest course data to be
 * displayed, while showing the finalized major requirements.
 *
 * Also, the URL returned does not have a specific year in it.
 *
 * @author bbieber
 */
class Latest extends Edition
{
    public function getURL()
    {
        return Controller::$url;
    }
}
