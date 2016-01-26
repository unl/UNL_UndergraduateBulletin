<script>
WDN.loadCSS(WDN.getTemplateFilePath('css/modules/pagination.css'));
</script>
<ul class="wdn_pagination">
    <?php if ($context->offset != 0) :?>
    <li class="arrow"><a href="<?php echo $context->url.'&amp;limit='.$context->limit.'&amp;offset='.($context->offset-$context->limit); ?>" title="Go to the previous page">&larr; prev</a></li>
    <?php endif; ?>
    <?php for ($page = 1; $page*$context->limit < $context->total+$context->limit; $page++ ) {
        $link = $context->url.'&amp;limit='.$context->limit.'&amp;offset='.($page-1)*$context->limit;
        $class = '';
        if (($page-1)*$context->limit == $context->offset) {
            $class = 'selected';
        }
    ?>
    <li class="<?php echo $class; ?>">
        <?php
        if ($class !== 'selected') { ?>
            <a href="<?php echo $link; ?>" title="Go to page <?php echo $page; ?>"><?php echo $page; ?></a>
        <?php
        } else {
            echo $page;
        } ?>
    </li>
    <?php } ?>
    <?php if (($context->offset+$context->limit) < $context->total) :?>
    <li class="arrow"><a href="<?php echo $context->url.'&amp;limit='.$context->limit.'&amp;offset='.($context->offset+$context->limit); ?>" title="Go to the next page">next &rarr;</a></li>
    <?php endif; ?>
</ul>
