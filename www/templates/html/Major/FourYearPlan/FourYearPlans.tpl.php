<section class="wdn-band four-year-plans">
	<div class="wdn-inner-wrapper">
    	<?php foreach ($context as $key => $concentration): ?>
            <h2><?php echo $key ?> <span class="wdn-subhead">4-Year Plan</span></h2>
            <div class="bp2-wdn-grid-set-halves wdn-grid-clear">
                <?php echo $savvy->render($concentration); ?>
            </div>
            <?php if (!empty($concentration->notes)): ?>
    	        <div class="wdn-grid-set">
                    <div class="wdn-col-full concentration-notes">
                        <h3>Notes</h3>
                        <p><?php echo nl2br($concentration->notes) ?></p>
                    </div>
                </div>
	        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<div class="wdn-band plan-notice">
    <div class="wdn-inner-wrapper">
        <div class="wdn_notice alert">
            <div class="message">
                <span class="title">PLEASE NOTE</span>
                <p>
                    This document represents a sample 4-year plan for degree completion with
                    this major. Actual course selection and sequence may vary and should be
                    discussed individually with your college or department academic adviser.
                    Advisers also can help you plan other experiences to enrich your
                    undergraduate education such as internships, education abroad,
                    undergraduate research, learning communities, and service learning and
                    community-based learning.
                </p>
            </div>
        </div>
    </div>
</div>
