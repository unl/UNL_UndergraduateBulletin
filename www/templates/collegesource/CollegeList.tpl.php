<?php
$colleges = array();

foreach ($context as $abbreviation => $college) {
    $colleges[] = array(
        'abbreviation'  => $abbreviation,
        'name'          => $college->getRaw('name'),
        'uri'           => $college->getURL()
    );
}

$i = 0;
foreach ($colleges as $college) {
    if ($i == 0) {
        $delimitArray(array_keys($college));
    }
    $i++;

    echo $delimitArray($college);
}