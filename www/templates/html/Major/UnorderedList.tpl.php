<ul id="majorListing" class="majorlisting">
    <?php foreach ($context as $major):
    $note = '';
    $class = array();
    if ($major->minorAvailable()) {
        $class[] = 'minorAvailable';
        $note = 'Minor&nbsp;Available';
    }
    
    if ($major->minorOnly()) {
        $class[] = 'minorOnly';
        $note = 'Minor&nbsp;Only';
    }
    
    foreach ($major->colleges as $college) {
        $class[] = $college->abbreviation;
    }
    ?>
    <li class="<?php echo implode(' ', $class); ?>"><a href="<?php echo $major->getRawObject()->getURL(); ?>">
        <span aria-hidden="true" class="major-img"></span>
        <span class="major-name"><?php echo $major->title; ?></span>
        <?php if ($note): ?> <span class="note"><?php echo $note; ?></span><?php endif; ?>
    </a></li>
    <?php endforeach; ?>
</ul>
