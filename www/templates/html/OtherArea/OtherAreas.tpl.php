<h2 class="bp2-clear-top">Academic Policies &amp; Other Academic Units</h2>
<ul>
<?php foreach ($context as $otherarea): ?>
    <li><a href="<?php echo $otherarea->getURL() ?>"><?php echo $otherarea->name ?></a></li>
<?php endforeach; ?>
</ul>
