#!/usr/bin/env php -q
<?php
if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

error_reporting(E_ALL);

if (empty($argv[1]) || empty($argv[2])) {
    echo "Usage: " . $argv[0] . " SUBJECT COURSE_NUMBER\n";
    exit(1);
}

$subject = $argv[1];
$courseNumber = $argv[2];
$foundReferences= array();

echo 'Searching for bulletin references to ' . $subject . ' ' . $courseNumber . '...' . PHP_EOL;

// Set edition
UNL_UndergraduateBulletin_Controller::setEdition(UNL_UndergraduateBulletin_Editions::getLatest());

foreach (new UNL_UndergraduateBulletin_CollegeList() as $college) {
    /* @var $college UNL_UndergraduateBulletin_College */
    foreach ($college->majors as $major) {
        /* @var $major UNL_UndergraduateBulletin_Major */
        $courses = UNL_UndergraduateBulletin_EPUB_Utilities::findCourses($major->getDescription()->description);

        if (empty($courses[$subject]) || !in_array($courseNumber, $courses[$subject])) {
            continue;
        }

        $foundReferences[$college->name][] = '  ' . $major->title . ' (' . $major->getURL() . ')';
    }
}
unset($college, $major);

foreach ($foundReferences as $collegeName => $majorReferences) {
    echo '****************************************************' . PHP_EOL . $collegeName . PHP_EOL;
    echo implode(PHP_EOL, $majorReferences) . PHP_EOL;
}
