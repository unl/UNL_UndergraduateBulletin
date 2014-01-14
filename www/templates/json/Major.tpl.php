<?php
switch($context->options['view']) {
    case 'major':
        echo $savvy->render($context->description);
        break;
    case 'plans':
        echo $savvy->render($context->getFourYearPlans());
        break;
    default:
        echo $savvy->render($context->subjectareas);
}