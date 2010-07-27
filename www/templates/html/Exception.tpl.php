<?php
switch($context->getCode()) {
    case 404:
        header('HTTP/1.0 404 Not Found');
        break;
    case 500:
        header('HTTP/1.0 500 Internal Server Error');
        break;
}
?>

<script type="text/javascript">
WDN.initializePlugin('notice');
</script>
<div class="wdn_notice alert">
    <div class="close">
        <a href="#" title="Close this notice">Close this notice</a>
    </div>
    <div class="message">
        <h4>Whoops! Sorry, there was an error:</h4>
        <p><?php echo $context->getMessage(); ?></p>
    </div>
    <!-- <?php echo $context; ?> -->
</div>