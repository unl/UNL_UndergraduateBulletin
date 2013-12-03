<form id="courseform" class="search" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search" method="get">
    <fieldset>
        <legend>Find a Course</legend>
        <label for="courseSearch">Course Search</label>
        <input type="text" placeholder="e.g. CSCE ace 3 honors" name="q" id="courseSearch" value="<?php echo (isset($controller->options['q']))?htmlentities($controller->options['q'], ENT_QUOTES):''; ?>" />
        <input type="submit" value="Find" name="submit" />
    </fieldset>
    <div class="search_help">
        <p>Search by Course Title (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=Global+Advertising">Global Advertising</a>), Course Code (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=ACCT">ACCT</a>), Course Number (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=438">438</a>) or advanced:</p>
        <ul>
            <li>Ace Outcome: <a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=ace+3">ace 3</a></li>
            <li>Course Number Range: <a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=2*">2*</a></li>
            <li>All Honors Courses: <a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=honors">honors</a></li>
            <li>Credit Hours: <a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=2+credits">2 credits</a></li>
        </ul>
    </div>
</form>
