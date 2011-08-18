<?php
if ($parent->parent->context->options['view'] == 'course') {
	echo '<courses xmlns="http://courseapproval.unl.edu/courses" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://courseapproval.unl.edu/courses /schema/courses.xsd">'.PHP_EOL;
}

echo '  '.str_replace('<?xml version="1.0"?>', '', $context->getRawObject()->asXML()).PHP_EOL;

if ($parent->parent->context->options['view'] == 'course') {
	echo '</courses>';
}
?>
