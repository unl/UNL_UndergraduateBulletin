<ol class="outcomes">
<?php
foreach ($context as $count => $description) {
    echo '<li>'.nl2br($description, true).'</li>';
}
?>
</ol>
