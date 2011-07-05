<courses xmlns="http://courseapproval.unl.edu/courses" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://courseapproval.unl.edu/courses /schema/courses.xsd">
<?php
foreach ($context->results as $course) {
    echo $savvy->render($course);
}
?>
</courses>