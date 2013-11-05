<?php
UNL_UndergraduateBulletin_Controller::setReplacementData('head', '
    <link rel="stylesheet" type="text/css" href="https://www.dropbox.com/s/3c8sgsducmf3l7s/fpa_4.0.css?dl=1" />
    <link rel="stylesheet" href="/wdn/templates_3.1/css/content/grid-v3.css" />
    <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" media="all" href="/wdn/templates_3.1/css/variations/grid-v3-ie.css" />
    <![endif]-->
');
?>
<section class="wdn-band">
	<div class="wdn-inner-wrapper">
	<?php
    foreach ($context as $key => $concentration) {
        echo '<h2>' . $key . ' - 4 Year Plan</h2>';
        echo '<div class="bp2-wdn-grid-set-halves wdn-clear-halves">';
        echo $savvy->render($concentration);
        echo '</div>';
    }
    ?>
    </div>
</section>
<section>
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
</section>
