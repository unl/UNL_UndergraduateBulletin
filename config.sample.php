<?php

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\OutputController;
use UNL\UndergraduateBulletin\CourseDataDriver;
use UNL\UndergraduateBulletin\CachingService\Mock;
use UNL\UndergraduateBulletin\CachingService\UNLCacheLite;
use UNL\UndergraduateBulletin\Course\DataDriver;
use UNL\UndergraduateBulletin\Editions\Edition;
use UNL\Services\CourseApproval\Data;
use UNL\Services\CourseApproval\CachingService\NullService;

// Set to false on production machines
ini_set('display_errors', true);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

// Set this to the web root for the site
Controller::$url = '/workspace/UNL_UndergraduateBulletin/www/';

// Remove this line on production machines so the default UNLCacheLite cache interface is used
OutputController::setCacheInterface(new Mock());
// OutputController::setCacheInterface(new UNLCacheLite(['cacheDir' => __DIR__ . '/tmp/']));
OutputController::setDefaultExpireTimestamp(strtotime('+1 week'));


// Mock::$logger = function($key) {
//    $log = 'unlcache_5174748813ed8803e7651fae9d2d077f_'.md5($key).PHP_EOL;
//    file_put_contents('/tmp/cachedfiles.txt', $log, FILE_APPEND);
// };

Data::setCachingService(new NullService());
Data::setXCRIService(new DataDriver());

// Controller::setEdition(new Edition(['year' => '2010']));
