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
    foreach ($college as $key=>$value) {
        if ($i == 0) {
            echo $delimiteArray($delimiter, array_keys($college));
        }

        echo $delimiteArray($delimiter, $college);
    }
    
    $i++;
}
