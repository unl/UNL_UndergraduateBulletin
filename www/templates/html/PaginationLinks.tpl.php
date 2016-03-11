<?php
$currentPage = floor($context->offset / $context->limit) + 1;
$totalPages = ceil($context->total / $context->limit);

$adjacentPageCount = 2;
$pageBookendCount = 2;
$pageMinimum = 7;
$pageWindow = $pageMinimum - $pageBookendCount - 1;
?>

<script>
WDN.loadCSS(WDN.getTemplateFilePath('css/modules/pagination.css'));
</script>

<ul class="wdn_pagination">
    <?php if ($currentPage > 1): ?>
        <li class="arrow">
            <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($currentPage - 2) * $context->limit ?>" title="Go to the previous page">← prev</a>
        </li>
    <?php else: ?>
        <li class="ellipsis">
            <span class="disabled" aria-disabled="true" title="Go to the previous page">← prev</span>
        </li>
    <?php endif; ?>
    </li>

    <?php if ($totalPages < $pageMinimum + $adjacentPageCount * 2): // not enough pages ?>
        <?php for ($counter = 1; $counter <= $totalPages; $counter++): ?>
            <li<?php if ($counter == $currentPage): ?> class="selected"<?php endif;?>>
                <?php if ($counter == $currentPage): ?>
                    <?php echo $counter ?>
                <?php else: ?>
                    <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($counter - 1) * $context->limit ?>"><?php echo $counter ?></a>
                <?php endif; ?>
            </li>
        <?php endfor; ?>
    <?php else: // enough pages to hide some ?>
        <?php if ($currentPage < 1 + $adjacentPageCount * 3): // close to the beginning ?>
            <?php for ($counter = 1; $counter < $pageWindow + $adjacentPageCount * 2; $counter++): ?>
                <li<?php if ($counter == $currentPage): ?> class="selected"<?php endif;?>>
                    <?php if ($counter == $currentPage): ?>
                        <?php echo $counter ?>
                    <?php elseif ($counter == 1): ?>
                        <a href="<?php echo $context->url ?>"><?php echo $counter ?></a>
                    <?php else: ?>
                        <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($counter - 1) * $context->limit ?>"><?php echo $counter ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>
            <li class="ellipsis">&hellip;</li>
            <?php for ($bookendCounter = $pageBookendCount; $bookendCounter > 0; $bookendCounter--): ?>
                <li>
                    <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($totalPages - $bookendCounter) * $context->limit ?>"><?php echo $totalPages - $bookendCounter + 1 ?></a>
                </li>
            <?php endfor; ?>
        <?php elseif ($totalPages - $adjacentPageCount * 2 > $currentPage && $currentPage > $adjacentPageCount * 2): // in the middle ?>
            <?php for ($bookendCounter = 0; $bookendCounter < $pageBookendCount; $bookendCounter++): ?>
                <li>
                    <?php if (!$bookendCounter): ?>
                        <a href="<?php echo $context->url ?>"><?php echo $bookendCounter + 1 ?></a>
                    <?php else: ?>
                        <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . $bookendCounter * $context->limit ?>"><?php echo $bookendCounter + 1 ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>
            <li class="ellipsis">&hellip;</li>

            <?php for ($counter = $currentPage - $adjacentPageCount; $counter <= $currentPage + $adjacentPageCount; $counter++): ?>
                <li<?php if ($counter == $currentPage): ?> class="selected"<?php endif;?>>
                    <?php if ($counter == $currentPage): ?>
                        <?php echo $counter ?>
                    <?php else: ?>
                        <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($counter - 1) * $context->limit ?>"><?php echo $counter ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>

            <li class="ellipsis">&hellip;</li>
            <?php for ($bookendCounter = $pageBookendCount; $bookendCounter > 0; $bookendCounter--): ?>
                <li>
                    <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($totalPages - $bookendCounter) * $context->limit ?>"><?php echo $totalPages - $bookendCounter + 1 ?></a>
                </li>
            <?php endfor; ?>
        <?php else: // close to end ?>
            <?php for ($bookendCounter = 0; $bookendCounter < $pageBookendCount; $bookendCounter++): ?>
                <li>
                    <?php if (!$bookendCounter): ?>
                        <a href="<?php echo $context->url ?>"><?php echo $bookendCounter + 1 ?></a>
                    <?php else: ?>
                        <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . $bookendCounter * $context->limit ?>"><?php echo $bookendCounter + 1 ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>
            <li class="ellipsis">&hellip;</li>

            <?php for ($counter = $totalPages - 1 - $adjacentPageCount * 3; $counter <= $totalPages; $counter++): ?>
                <li<?php if ($counter == $currentPage): ?> class="selected"<?php endif;?>>
                    <?php if ($counter == $currentPage): ?>
                        <?php echo $counter ?>
                    <?php else: ?>
                        <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($counter - 1) * $context->limit ?>"><?php echo $counter ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($currentPage < $counter - 1): ?>
        <li class="arrow">
            <a href="<?php echo $context->url . '&amp;limit=' . $context->limit . '&amp;offset=' . ($currentPage * $context->limit); ?>" title="Go to the next page">next →</a>
        </li>
    <?php else: ?>
        <li class="ellipsis">
            <span class="disabled" aria-disabled="true" title="Go to the next page">next →</span>
        </li>
    <?php endif; ?>
    </li>
</ul>
