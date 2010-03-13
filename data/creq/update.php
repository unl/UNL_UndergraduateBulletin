<?php

$subjects = file(dirname(__FILE__).'/subject_codes.csv', FILE_IGNORE_NEW_LINES);
foreach ($subjects as $subject) {
    if ($data = file_get_contents('http://creq.unl.edu/courses/public-view/all-courses/subject/'.$subject)) {
        file_put_contents(dirname(__FILE__).'/subjects/'.$subject.'.xml', $data);
    } else {
        echo 'Could not retrieve data for '.$subject.PHP_EOL;
    }
}