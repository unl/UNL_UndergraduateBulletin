<form id="majorform" class="search" action="<?php echo $controller->getRawObject()::getURL(); ?>major/search" method="get">
    <fieldset>
        <legend>Find a Major or Degree</legend>
        <label for="majorSearch">Major or Degree</label>
        <input type="text" name="q" placeholder="search for a major/degree" id="majorSearch"  value="<?php echo (isset($controller->options['q']))?$controller->options['q']:''; ?>" />
        <input type="submit" value="Find" />
    </fieldset>
</form>
