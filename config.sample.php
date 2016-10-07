<?php

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\CatalogController;
use UNL\UndergraduateBulletin\GraduateController;
use UNL\UndergraduateBulletin\OutputController;
use UNL\UndergraduateBulletin\CourseDataDriver;
use UNL\UndergraduateBulletin\CachingService\Mock;
use UNL\UndergraduateBulletin\CachingService\UNLCacheLite;
use UNL\UndergraduateBulletin\Course\DataDriver;
use UNL\UndergraduateBulletin\Edition\Edition;
use UNL\UndergraduateBulletin\Edition\Next;
use UNL\Services\CourseApproval\Data;
use UNL\Services\CourseApproval\CachingService\NullService;

// Set to false on production machines
ini_set('display_errors', true);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

// Set this to the web root for the site
Controller::$url = '/workspace/UNL_UndergraduateBulletin/www/';
CatalogController::$url = '/workspace/UNL_UndergraduateBulletin/www/course-catalog/';
GraduateController::$url = '/workspace/UNL_UndergraduateBulletin/www/graduate/';

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

if (isset($_SERVER['BULLETIN_EDITION'])) {
	$edition = new Edition(['year' => $_SERVER['BULLETIN_EDITION']]);
	if ($_SERVER['BULLETIN_EDITION'] === 'next') {
		$edition = new Next();
	}

	Controller::setEdition($edition);
	unset($edition);
}

// Controller::setEdition(new Edition(['year' => '2010']));
