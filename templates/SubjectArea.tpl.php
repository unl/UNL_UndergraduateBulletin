<?php
echo '<h1>'.htmlentities($this->subject).'</h1>';

echo  '<dl>';

foreach ($this->courses as $course) {
    include dirname(__FILE__).'/Course.tpl.php';
}
echo  '</dl>';

?>