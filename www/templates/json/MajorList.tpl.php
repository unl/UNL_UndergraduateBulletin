<?php
$majors = array();

foreach ($context as $major) {
    $majors[] = array(
        'title'          => $major->getRaw('title'),
        'minorAvailable' => $major->minorAvailable(),
        'college'        => (isset($major->colleges)?$major->colleges->getArray():''),
        'uri'			 => $major->getURL()
        );
}
echo json_encode($majors);