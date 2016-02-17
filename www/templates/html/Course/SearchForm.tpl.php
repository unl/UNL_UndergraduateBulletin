<?php
$url =  $controller->getRawObject()::getURL();
?>
<form id="courseform" class="search" action="<?php echo $url ?>courses/search" method="get">
    <label for="courseSearch">Course Search</label>
    <div class="ui-front">
        <div class="wdn-input-group">
            <input type="text" name="q" id="courseSearch" value="<?php echo (isset($controller->options['q']))?$controller->options['q']:''; ?>" />
            <div class="wdn-input-group-btn">
                <button type="submit">Find</button>
            </div>
        </div>
    </div>
    <p class="search_help">
        Samples: Title (<a class="operator" href="<?php echo $url ?>courses/search?q=Global+Advertising">Global Advertising</a>),
        Subject Code (<a class="operator" href="<?php echo $url ?>courses/search?q=ACCT">ACCT</a>),
        Number (<a class="operator" href="<?php echo $url ?>courses/search?q=438">438</a>),
        Number Range (<a class="operator" href="<?php echo $url ?>courses/search?q=2*">2*</a>),
        Ace Outcome (<a class="operator" href="<?php echo $url ?>courses/search?q=ace+3">ace 3</a>),
        Honors Courses (<a class="operator" href="<?php echo $url ?>courses/search?q=honors">honors</a>),
        Credit Hours (<a class="operator" href="<?php echo $url ?>courses/search?q=2+credits">2 credits</a>),
        or combine terms (<a class="operator" href="<?php echo $url ?>courses/search?q=ace+3+CSCE+honors">ace 3 CSCE honors</a>)
    </p>
</form>
