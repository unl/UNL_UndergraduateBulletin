<?php

require '../config.sample.php';

$subjects = new UNL_UndergraduateBulletin_SubjectAreas();

echo 'code,title,college,major'.PHP_EOL;

foreach ($subjects as $code=>$title) {
    try {
        $major = new UNL_UndergraduateBulletin_Major(array('name'=>$title));
        $major->run();
        $major->college;
        $college = $major->college->abbreviation;
        $major = $major->title;
    } catch(Exception $e) {
        $major = '';
        $college = '';
    }
    echo $code.',"'.$title.'",'.$college.','.$major.PHP_EOL;
}

