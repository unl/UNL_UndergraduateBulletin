<form class="" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>major/search" method="get" style="margin-top:10px;">
    <fieldset>
        <legend>Find a Major or Degree</legend>
        <label for="majorSearch"><span class="required">*</span>Major or Degree</label>
        <input type="text" name="q" id="majorSearch"  value="<?php echo (isset($parent->context->options['q']))?htmlentities($parent->context->options['q'], ENT_QUOTES):''; ?>" />
        <input type="submit" value="Find" name="submit" />
    </fieldset>
</form>