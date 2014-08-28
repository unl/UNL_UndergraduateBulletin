<h1>Undergraduate Bulletin <?php echo UNL_UndergraduateBulletin_Controller::getEdition()->getRange(); ?></h1>

<?php foreach ($context->policies as $page): ?>
    <section class="general">
    <?php echo UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($page->getRawObject()->getDescription()); ?>
    </section>
<?php endforeach; ?>

<?php foreach ($context->colleges as $college): ?>
    <section class="college">
    <?php echo UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($college->getRawObject()->getDescription()); ?>
    <?php foreach ($college->getRaw('majors') as $major): ?>
        <section class="major">
        <?php echo $major->getDescription()->description; ?>
        </section>
    <?php endforeach; ?>
    </section>
<?php endforeach; ?>