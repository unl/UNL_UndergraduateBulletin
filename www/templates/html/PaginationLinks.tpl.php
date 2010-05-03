<script type="text/javascript">
WDN.loadCSS('/wdn/templates_3.0/css/content/pagination.css');
</script>
<ul class="wdn_pagination">
    <li class="arrow"><a href="#" title="Go to the previous page">&larr; prev</a></li>
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
    <li class="arrow"><a href="#" title="Go to the next page">next &rarr;</a></li>
</ul>