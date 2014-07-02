<?php
$subjects = array();
foreach ($context as $subject_code => $area) {
    $subjects[$subject_code] = array(
        'href'  => UNL_UndergraduateBulletin_Controller::getURL().'courses/'.$subject_code.'/',
        'title' => $area->title
    );
}

echo json_encode($subjects);
