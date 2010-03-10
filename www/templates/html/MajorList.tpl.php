<h1>Select A Major or Area of Study</h1>
<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
?>
<ul>
    <?php foreach ($context as $major): ?>
    <li><a href="<?php echo $url; ?>major/<?php echo urlencode($major); ?>"><?php echo $major; ?></a></li>
    <?php endforeach; ?>
</ul>