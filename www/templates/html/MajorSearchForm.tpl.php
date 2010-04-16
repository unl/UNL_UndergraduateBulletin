<form class="zenform soothing" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>major/search" method="get" style="margin-top:10px;">
    <h3>Find a Major or Degree</h3>
    <fieldset>
        <legend>Find a Major or Degree</legend>
    <ol>
    <li>
        <label for="majorSearch"><span class="required">*</span>Major or Degree</label>
        <input type="text" name="q" id="majorSearch"  value="<?php echo (isset($parent->context->options['q']))?htmlentities($parent->context->options['q'], ENT_QUOTES):''; ?>" />
        
    </li>
    </ol>
    </fieldset>
    <input type="submit" value="Search" name="submit" />
</form>