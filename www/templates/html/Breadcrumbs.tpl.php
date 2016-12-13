<ul>
    <li><a href="http://www.unl.edu/">Nebraska</a>
    <li><a href="http://svcaa.unl.edu/">Academic Affairs</a>
    <li><a href="<?php echo $savvy->escape(\UNL\UndergraduateBulletin\CatalogController::getBaseURL()) ?>">Bulletins</a>
    <?php foreach ($context->getCrumbs() as $crumb): ?>
    <?php $isUrl = isset($crumb['url']) && $crumb['url']; ?>
    <li>
        <?php if ($isUrl): ?>
            <a href="<?php echo $crumb['url'] ?>">
        <?php endif; ?>

        <?php echo $crumb['title'] ?>

        <?php if ($isUrl): ?>
            </a>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>

</ul>
