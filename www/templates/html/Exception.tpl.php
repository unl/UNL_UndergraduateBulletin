<?php
/* @var $context Exception */
if (false == headers_sent()
    && $code = $context->getCode()) {
    header('HTTP/1.1 '.$code.' '.$context->getMessage());
    header('Status: '.$code.' '.$context->getMessage());
}
?>

<script>
WDN.initializePlugin('notice');
</script>
<div class="wdn_notice alert">
    <div class="close">
        <a href="#">Close this notice</a>
    </div>
    <div class="message">
        <p class="title">Whoops! Sorry, there was an error:</p>
        <p><?php echo $context->getMessage(); ?></p>
    </div>
</div>
