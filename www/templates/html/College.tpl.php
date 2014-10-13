<div class="wdn-inner-wrapper">
    <div class="wdn-grid-set">
        <div class="bp2-wdn-col-two-thirds">
            <div id="toc_nav">
                <a id="tocToggle" href="#">+</a>
                <ol id="toc"><li>Intro</li></ol>
                <div id="toc_major_name"><?php echo $context->name; ?></div>
            </div>
            <div id="long_content">
            <?php
            echo UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($context->getRaw('description')); ?>
            </div>
        </div>
        <div class="bp2-wdn-col-one-third">
            <?php
            $related_majors = $savvy->render($context->majors, 'MajorList/UnorderedList.tpl.php');
            // Check if there are any actual majors in the list
            if (false !== strpos($related_majors, '</li>')):
            ?>
            <h3 id="relatedMajors">Majors</h3>
            <?php 
            echo $related_majors;
            endif;
            ?>
        </div>
    </div>
</div>