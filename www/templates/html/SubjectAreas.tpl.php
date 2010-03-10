<h2>All subject areas</h2>
<ul>
<?php
foreach ($context as $subject_code) {
    echo '<li><a href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/'.$subject_code.'/">'.$subject_code.'</a></li>';
}
?>
</ul>