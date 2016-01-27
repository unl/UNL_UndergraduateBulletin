<?php
use UNL\UndergraduateBulletin\Controller;
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Undergraduate Bulletin | University of Nebraska-Lincoln</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo Controller::getBaseURL() ?>css/print_book.css" />
    </head>
    <body>
        <?php echo $savvy->render($context->output); ?>
    </body>
</html>
