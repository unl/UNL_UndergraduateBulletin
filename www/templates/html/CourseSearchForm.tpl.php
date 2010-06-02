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
    <div id="courseSearchHelp" style="display:none">
        <h4>Searching for a Course</h4>
        <p>Search by Course Title (<span class="operator">Global Advertising</span>), Course Code (<span class="operator">ADVT</span>), Course Number (<span class="operator">438</span>) or advanced:</p>
        <ul>
            <li>Ace Outcome: <span class="operator">ace 3</span></li>
            <li>Course Number Range: <span class="operator">2XX</span></li>
            <li>All Honors Courses: <span class="operator">honors</span></li>
        </ul>
    </div>
</form>