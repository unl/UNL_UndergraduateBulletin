<script type="text/javascript">
//<![CDATA[
	WDN.jQuery(document).ready(function(){
	     WDN.initializePlugin('zenform');
	});
//]]>
</script>
<form class="zenform cool" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search" method="get">
    <fieldset>
        <legend>Find a Course</legend>
    <ol>
    <li>
        <label for="courseSearch"><span class="required">*</span>Course</label>
        <input type="text" name="q" id="courseSearch" value="<?php echo (isset($parent->context->options['q']))?htmlentities($parent->context->options['q'], ENT_QUOTES):''; ?>" />
    </li>
    </ol>
    </fieldset>
    <input type="submit" value="Search" name="submit" />
    <div id="courseSearchResults"></div>
</form>