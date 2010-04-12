<?php

$data = array();

$data['title']        = $context->title;
$data['description']  = $context->description;
$data['prerequisite'] = $context->prerequisite;
$data['courseCodes']  = array();
foreach ($context->codes as $listing) {
    $data['courseCodes'][] = array('subject'      => (string)$listing->subjectArea,
                                   'courseNumber' => $listing->courseNumber);
}

echo json_encode($data);

?>