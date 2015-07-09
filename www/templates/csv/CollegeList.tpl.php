<?php
$colleges = array();
$fields = array(
    'abbreviation',
    'name',
    'uri',
);

$delimitArray($fields);

foreach ($context as $abbreviation => $college) {
    $colleges[] = array_combine($fields, array(
        $abbreviation,
        $college->name,
        $college->getURL()
    ));
}

foreach ($colleges as $college) {
    $delimitArray($college);
}
