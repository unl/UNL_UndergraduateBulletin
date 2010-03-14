<form class="cool compact" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>major/search" method="get">
    <fieldset>
        <legend>Find a Major or Degree</legend>
    <ol>
    <li>
        <label for="majorSearch" class="element">Major or Degree</label>
        <div class="element">
            <input type="text" name="q" id="majorSearch"  value="<?php echo (isset($parent->context->options['q']))?htmlentities($parent->context->options['q'], ENT_QUOTES):''; ?>" />
        </div>
    </li>
    </ol>
    </fieldset>
    <p class="submit">
        <input type="submit" value="Search" name="submit" />
    </p>
    <div id="majorSearchResults"></div>
</form>