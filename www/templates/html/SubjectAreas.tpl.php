<h2>All subject areas</h2>
<ul>
<?php
foreach ($context as $subject_code=>$title) {
    echo '<li><a href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/'.$subject_code.'/"><span class="subjectCode">'.$subject_code.'</span> <span class="title">'.$title.'</span></a></li>';
}
?>
</ul>