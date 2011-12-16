<?php
$subjects = array();
foreach ($context as $subject_code => $area) {
    $subjects[$subject_code] = array(
        'href' => 'http://'.$_SERVER['SERVER_NAME'].UNL_UndergraduateBulletin_Controller::getURL().'courses/'.$subject_code.'/',
        'title' => $area->getRaw('title')
    );
}

echo json_encode($subjects);
