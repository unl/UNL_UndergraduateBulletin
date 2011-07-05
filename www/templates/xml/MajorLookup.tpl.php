<plans>
<?php foreach ($context as $code=>$title): ?>
    <p xml:id="<?php echo $code ?>"><?php echo htmlentities($title) ?></p>
<?php endforeach; ?>
</plans>