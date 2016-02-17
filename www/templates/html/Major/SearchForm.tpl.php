<form id="majorform" class="search " action="<?php echo $controller->getRawObject()::getURL(); ?>major/search" method="get">
    <label for="majorSearch">Major or Degree</label>
    <div class="ui-front">
        <div class="wdn-input-group">
            <input type="text" name="q" id="majorSearch"  value="<?php echo (isset($controller->options['q']))?$controller->options['q']:''; ?>" />
            <div class="wdn-input-group-btn">
                <button type="submit">Find</button>
            </div>
        </div>
    </div>
</form>
