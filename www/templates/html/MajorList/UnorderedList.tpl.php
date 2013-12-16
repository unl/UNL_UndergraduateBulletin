<div class="wdn-inner-wrapper">
    <ul id="majorListing" class="majorlisting">
        <?php foreach ($context as $major):
        $class = '';
        if ($major->minorAvailable()) {
            $class .= 'minorAvailable ';
        }
        if ($major->minorOnly()) {
            $class .= 'minorOnly ';
        }
        
        foreach ($major->colleges as $college) {
            $class .= $college->abbreviation.' ';
        }
        ?>
        <li class="<?php echo trim($class); ?>"><a href="<?php echo $major->getRawObject()->getURL(); ?>"><?php echo $major->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>