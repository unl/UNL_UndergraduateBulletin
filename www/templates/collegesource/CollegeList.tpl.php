<?php
$colleges = array();

foreach ($context as $abbreviation => $college) {
    $colleges[] = array(
        'abbreviation'  => $abbreviation,
        'name'          => $college->name,
        'uri'           => $college->getURL()
    );
}

$i = 0;
foreach ($colleges as $college) {
    if ($i == 0) {
        $delimitArray(array_keys($delimiter, $college));
    }
    $i++;

    echo $delimitArray($delimiter, $college);
}