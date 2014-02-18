<form id="majorform" class="search" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>major/search" method="get">
    <fieldset>
        <legend>Find a Major or Degree</legend>
        <label for="majorSearch">Major or Degree</label>
        <input type="text" name="q" placeholder="search for a major/degree" id="majorSearch"  value="<?php echo (isset($controller->options['q']))?htmlentities($controller->options['q'], ENT_QUOTES):''; ?>" />
        <input type="submit" value="Find" name="submit" />
    </fieldset>
</form>