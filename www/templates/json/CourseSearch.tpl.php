<?php

$courses = array();

echo '[';
foreach ($context->results as $course) {
    $courses[] = $savvy->render($course);
}
echo implode(','.PHP_EOL, $courses);
echo ']';