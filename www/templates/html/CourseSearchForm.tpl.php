<form class="zenform soothing" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search" method="get">
    <h3>Find a Course</h3>
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