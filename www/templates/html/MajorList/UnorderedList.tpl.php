<ul id="majorListing">
    <?php foreach ($context as $major):
    $class = '';
    if ($major->minorAvailable()) {
        $class .= 'minorAvailable ';
    }
    if ($major->minorOnly()) {
        $class .= 'minorOnly ';
    }
    
    if (isset($major->college)) {
        try {
            $class .= $major->college->abbreviation.' ';
        } catch(Exception $e) {
            echo '<!-- Unable to retieve college abbreviation '.$e->getMessage().' -->';
        }
    }
    ?>
    <li class="<?php echo trim($class); ?>"><a href="<?php echo $major->getRawObject()->getURL(); ?>"><?php echo $major->title; ?></a></li>
    <?php endforeach; ?>
</ul>