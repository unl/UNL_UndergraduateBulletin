<?php

$permalink = $context->getURL();

$controller->getRawObject()::setReplacementData('head', '
    <link rel="alternate" type="text/xml" href="'.$permalink.'?format=xml" />
    <link rel="alternate" type="text/javascript" href="'.$permalink.'?format=json" />
    <link rel="alternate" type="text/html" href="'.$permalink.'?format=partial" />'
);
$controller->getRawObject()::setReplacementData('doctitle', $context->getTitle() . ' | Undergraduate Bulletin | University of Nebraska-Lincoln');
$controller->getRawObject()::setReplacementData('breadcrumbs', '
    <ul>
        <li><a href="http://www.unl.edu/">UNL</a></li>
        <li><a href="'.$controller->getURL().'">Undergraduate Bulletin</a></li>
        <li>'.$context->getTitle().'</li>
    </ul>
    ');
?>
<?php echo $savvy->render($context->getCourse()); ?>
