<form id="courseform" class="search" action="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search" method="get">
    <fieldset>
        <legend>Find a Course</legend>
        <label for="courseSearch">Course Search</label>
        <input type="text" placeholder="search for a course" name="q" id="courseSearch" value="<?php echo (isset($controller->options['q']))?htmlentities($controller->options['q'], ENT_QUOTES):''; ?>" />
        <input type="submit" value="Find" name="submit" />
    </fieldset>
    <div class="search_help">
        <p>
        Samples: Title (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=Global+Advertising">Global Advertising</a>),
        Subject Code (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=ACCT">ACCT</a>),
        Number (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=438">438</a>),
        Number Range (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=2*">2*</a>),
        Ace Outcome (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=ace+3">ace 3</a>),
        Honors Courses (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=honors">honors</a>),
        Credit Hours (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=2+credits">2 credits</a>),
        or combine terms (<a class="operator" href="<?php echo UNL_UndergraduateBulletin_Controller::getURL(); ?>courses/search?q=ace+3+CSCE+honors">ace 3 CSCE honors</a>)
        </p>
    </div>
</form>
