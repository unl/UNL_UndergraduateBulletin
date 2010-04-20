<?php
$majors = array();

foreach ($context as $major) {
    $majors[] = array(
        'title'          => $major->getRaw('title'),
        'minorAvailable' => $major->minorAvailable(),
        'college'        => (isset($major->college->name)?$major->college->getRaw('name'):'')
        );
}
echo json_encode($majors);