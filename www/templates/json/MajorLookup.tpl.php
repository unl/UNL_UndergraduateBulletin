<?php
$plans = array();
foreach ($context as $code=>$title) {
    $plans[$code] = $title;
}

echo json_encode($plans);
