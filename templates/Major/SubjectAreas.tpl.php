<div class="four_col">
<h2>Courses of Instruction</h2>
<?php
foreach ($this->major->subjectareas as $subject) {
    UNL_UndergraduateBulletin_OutputController::display($subject);
}
?>
</div>