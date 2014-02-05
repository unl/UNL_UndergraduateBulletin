<section class="wdn-band four-year-plans">
	<div class="wdn-inner-wrapper">
    	<?php
        foreach ($context as $key => $concentration) {
            echo '<h2 class="wdn-brand">' . $key . ' <span class="outcome">Learning Outcome</span></h2>';
            echo '<div class="bp2-wdn-grid-set-halves wdn-grid-clear">';
            echo $savvy->render($concentration);
            echo '</div>';
            if (!empty($concentration->notes)) {
                echo '<div class="wdn-grid-set">
                    <div class="wdn-col-full concentration-notes">
                        <h3>Notes</h3>
                        <p>'.$concentration->notes.'</p>
                    </div>
                </div>';
            }
        }
        ?>
    </div>
</section>
