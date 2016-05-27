<?php

namespace UNL\UndergraduateBulletin\Edition;

use UNL\UndergraduateBulletin\GraduateController;

/**
 * This edition is slightly unique. COURSE data is pulled from the NEXT edition.
 * This folder is what will be used to cut a new yearly edition
 *
 */
class NextGraduate extends Next
{
    public function getURL()
    {
        return GraduateController::getBaseURL();
    }
}
