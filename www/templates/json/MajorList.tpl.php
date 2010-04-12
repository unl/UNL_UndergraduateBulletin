<?php
$majors = array();

foreach ($context as $major) {
    $majors[] = $major->title;
}
echo json_encode($majors);