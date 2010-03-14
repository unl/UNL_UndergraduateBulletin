<form class="cool compact" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search" method="get">
    <fieldset>
        <legend>Find a Course</legend>
    <ol>
    <li>
        <label for="courseSearch" class="element">Course</label>
        <div class="element">
            <input type="text" name="q" id="courseSearch" value="<?php echo (isset($parent->context->options['q']))?htmlentities($parent->context->options['q'], ENT_QUOTES):''; ?>" />
        </div>
    </li>
    </ol>
    </fieldset>
    <p class="submit">
        <input type="submit" value="Search" name="submit" />
    </p>
    <div id="courseSearchResults"></div>
</form>