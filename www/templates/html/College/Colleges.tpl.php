<div class="wdn-band">
	<div class="wdn-inner-wrapper">
		<ul id="collegeListing">
			<?php foreach ($context as $college): ?>
			    <li><a href="<?php echo $college->getURL() ?>"><?php echo $college->name ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
