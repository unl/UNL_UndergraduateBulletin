<?php
$colleges = array();

foreach ($context as $abbreviation=>$college) {
    $colleges[] = array(
        'abbreviation'  => $abbreviation,
        'name'          => $college->getRaw('name'),
        'uri'           => $college->getURL()
        );
}
echo json_encode($colleges);