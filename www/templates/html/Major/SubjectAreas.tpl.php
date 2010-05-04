<?php
foreach ($context->major->subjectareas as $subject) {
    echo $savvy->render($subject);
    echo '<div class="clear"></div>';
}
?>