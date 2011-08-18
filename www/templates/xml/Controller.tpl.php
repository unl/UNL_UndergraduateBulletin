<?php echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;

if ($context->options['view'] == 'course') {
    echo '<courses xmlns="http://courseapproval.unl.edu/courses" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://courseapproval.unl.edu/courses /schema/courses.xsd">'.PHP_EOL;
}

echo $savvy->render($context->output);

if ($context->options['view'] == 'course') {
    echo '</courses>';
}
?>
