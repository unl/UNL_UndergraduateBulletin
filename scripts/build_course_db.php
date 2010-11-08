#!/usr/bin/env php -q
<?php
if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

$search_service = new UNL_Services_CourseApproval_Search();

$courses = $search_service->byAny('',
                                  0,
                                  4000
                                  );
$id = 0;

@unlink(UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/courses.sqlite');

$db = new PDO('sqlite:'.UNL_UndergraduateBulletin_Controller::getDataDir().'/creq/courses.sqlite');
//$db = new PDO('mysql:dbname=ug_bulletin;host=127.0.0.1', 'ug_bulletin', 'ug_bulletin');

$db->exec('CREATE TABLE IF NOT EXISTS courses (
id INT UNSIGNED NOT NULL ,
subjectArea VARCHAR( 4 ) NOT NULL ,
courseNumber VARCHAR( 4 ) NOT NULL ,
title VARCHAR( 255 ) NOT NULL ,
slo VARCHAR( 20 ) NOT NULL ,
credits INT UNSIGNED NULL ,
xml MEDIUMTEXT NOT NULL ,
PRIMARY KEY ( id )
);');

$db->exec('CREATE INDEX IF NOT EXISTS main.subjectArea ON courses ( subjectArea );');
$db->exec('CREATE INDEX IF NOT EXISTS main.courseNumber ON courses ( courseNumber );');
$db->exec('CREATE INDEX IF NOT EXISTS main.credits ON courses ( credits );');

$db->exec('ALTER TABLE `courses` ADD INDEX ( `subjectArea` )  ');
$db->exec('ALTER TABLE `courses` ADD INDEX ( `courseNumber` )  ');
$db->exec('ALTER TABLE `courses` ADD INDEX ( `credits` )  ');

$db->exec('CREATE TABLE IF NOT EXISTS crosslistings (
course_id INT UNSIGNED NOT NULL ,
subjectArea VARCHAR( 4 ) NOT NULL ,
courseNumber VARCHAR( 4 ) NOT NULL
);');

$db->exec('CREATE INDEX IF NOT EXISTS main.subjectArea ON crosslistings ( subjectArea );');
$db->exec('CREATE INDEX IF NOT EXISTS main.courseNumber ON crosslistings ( courseNumber );');
$db->exec('ALTER TABLE `crosslistings` ADD INDEX ( `subjectArea` )  ');
$db->exec('ALTER TABLE `crosslistings` ADD INDEX ( `courseNumber` )  ');


$course_stmt = $db->prepare('INSERT INTO courses (id,subjectArea,courseNumber,title,slo,credits,xml) VALUES (?,?,?,?,?,?,?);');
$cross_stmt =  $db->prepare('INSERT INTO crosslistings (course_id, subjectArea, courseNumber) VALUES (?,?,?);');

foreach ($courses as $course) {
    $id++;
    /**
     * @var UNL_Services_CourseApproval_Course $course
     */
    //$course = new UNL_Services_CourseApproval_Course();
    $home = $course->getHomeListing();

    $values = array();
    $values[] = $id;
    $values[] = (string)$home->subjectArea;
    $values[] = $home->courseNumber;
    //$values[] = $home->courseLetter;
    $values[] = $course->title;
    if (isset($course->aceOutcomes)) {
        $values[] = implode(',', $course->aceOutcomes);
    } else {
        $values[] = '';
    }

    $credits = $course->getCredits();
    if (isset($credits['Single Value'])) {
        $values[] = $credits['Single Value'];
    } else {
        $values[] = NULL;
    }
    
    $values[] = $course->asXML();
    
    $course_stmt->execute($values);
    
    foreach ($course->codes as $listing) {
        $values = array($id, $listing->subjectArea, $listing->courseNumber);
        $cross_stmt->execute($values);
    }
}