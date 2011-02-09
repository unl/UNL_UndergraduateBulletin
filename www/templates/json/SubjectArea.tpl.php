<?php
/**
 * @var $context UNL_UndergraduateBulletin_SubjectArea
 */
$courses = array();
echo '{
"id"      : "'.$context->subject.'",
"title"   : "'.$context->title.'",
"courses" :';
echo '[';
foreach ($context->courses as $course) {
    $courses[] = $savvy->render($course);
}
echo implode(','.PHP_EOL, $courses);
echo ']';
echo '}';