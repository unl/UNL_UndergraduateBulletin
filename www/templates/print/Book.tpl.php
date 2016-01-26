<?php
use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\EPUB\Utilities;
?>
<h1>Undergraduate Bulletin <?php echo Controller::getEdition()->getRange(); ?></h1>

<?php foreach ($context->policies as $page): ?>
    <section class="general">
        <?php echo Utilities::convertHeadings($page->getRawObject()->getDescription()); ?>
    </section>
<?php endforeach; ?>

<?php foreach ($context->colleges as $college): ?>
    <section class="college">
        <?php echo Utilities::convertHeadings($college->getRawObject()->getDescription()); ?>
        <?php foreach ($college->getRaw('majors') as $major): ?>
            <section class="major">
                <?php echo $major->getDescription()->description; ?>
            </section>
        <?php endforeach; ?>
    </section>
<?php endforeach; ?>
