<?php
echo '[';
foreach ($context->results as $course) {
    echo $savvy->render($course).','.PHP_EOL;
}
echo ']';