<div class="wdn-grid-set">
    <div class="bp2-wdn-col-one-fourth">
        <?php echo $savvy->render(null, 'MajorList/Filters.tpl.php'); ?>
    </div>
    <div class="bp2-wdn-col-three-fourths">
        <h2 class="clear-top">Select A Major or Area of Study</h2>
        <?php echo $savvy->render($context, 'MajorList/UnorderedList.tpl.php'); ?>
    </div>
</div>
