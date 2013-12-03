<?php
UNL_UndergraduateBulletin_Controller::setReplacementData('head', '
    <link rel="stylesheet" type="text/css" href="'.UNL_UndergraduateBulletin_Controller::getBaseURL().'templates/html/css/modules.courses.css" />
');
?>
<section class="wdn-band">
	<div class="wdn-inner-wrapper">
    	<?php
        foreach ($context as $key => $concentration) {
            echo '<h2>' . $key . ' <span class="wdn-4yrplan">4 Year Plan</span></h2>';
            echo '<div class="bp2-wdn-grid-set-halves wdn-grid-clear">';
            echo $savvy->render($concentration);
            echo '</div>
            <div class="wdn-grid-set">
            <div class="wdn-col-full">
            <h3>Concentration Notes</h3>
            <p>'.$concentration->notes.'</p>
            </div>
            </div>';
        }
        ?>
        <h3>Note</h3>
        <p>
        This document represents a sample 4-year plan for degree completion with
        this major. Actual course selection and sequence may vary and should be
        discussed individually with an academic adviser at the college and/or
        department. Advisers can also help students plan for other experiences that
        will enrich their undergraduate education such as internships, education
        abroad, undergraduate research, learning communities, and service learning
        and community-based learning.
        </p>
    </div>
</section>
