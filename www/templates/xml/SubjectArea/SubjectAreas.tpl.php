<subjects xmlns:xlink="http://www.w3.org/1999/xlink">
<?php foreach ($context as $subject_code => $area): ?>
    <s xlink:href="<?php echo $controller->getRawObject()::getURL() .'courses/'.$subject_code.'/' ?>" xml:id="<?php echo $subject_code ?>"><?php echo $area->title ?></s>
<?php endforeach; ?>
</subjects>