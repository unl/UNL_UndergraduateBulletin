<h2 class="college-name"><?php echo $context->college->name; ?></h2>
<?php
if (count($context)) {
    echo $savvy->render($context, 'MajorList/UnorderedList.tpl.php');
}
?>