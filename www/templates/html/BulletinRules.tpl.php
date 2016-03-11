<?php

use UNL\UndergraduateBulletin\Edition\Editions;

$rawController = $controller->getRawObject();
$baseURL = $rawController::getBaseURL();
$colleges = new UNL\UndergraduateBulletin\College\Colleges();
?>
<div class="wdn-band">
<div class="wdn-inner-wrapper">
<div class="wdn_notice" id="officialMessage">
    <div class="message">
        <span class="title">PLEASE NOTE:</span>
        <p>Students who enter a college within the University in the <?php echo $rawController::getEdition()->getRange(); ?> academic year are expected to complete the graduation requirements set forth by that college in this bulletin.
        Students are responsible for knowing which bulletin they should follow.</p>
    </div>
</div>
</div>
</div>

<div class="wdn-band">
<div class="wdn-inner-wrapper">
<div class="wdn-grid-set">
    <div class="bp1-wdn-col-three-fourths">
        <h3 class="clear-top">COLLEGE BULLETIN USAGE RULES</h3>
        <?php foreach ($colleges as $college): ?>
            <?php if (isset($college->description->bulletinRule)): ?>
                <h4><?php echo $savvy->escape($college->name) ?></h4>
                <?php echo $college->description->bulletinRule ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="bp1-wdn-col-one-fourth">
        <div class="zenbox cool">
            <h3>All Bulletins</h3>
            <ul>
                <?php
                $current = $rawController::getEdition();
                foreach (Editions::getPublished() as $edition):
                    $class = '';
                    if ($edition->getURL() == $current->getURL()) {
                        $class = 'selected';
                    }
                    ?>
                    <li class="<?php echo $class; ?>"><a href="<?php echo $edition->getURL(); ?>"><?php echo $edition->getRange(); ?></a></li>
                <?php endforeach; ?>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0910.pdf" title="Undergraduate Bulletin 2009-2010, in PDF format (8.6MB)">2009-2010</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0809.pdf" title="Undergraduate Bulletin 2008-2009, in PDF format (8.7MB)">2008-2009</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0708.pdf" title="Undergraduate Bulletin 2007-2008, in PDF format (3.2MB)">2007-2008</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0607.pdf" title="Undergraduate Bulletin 2006-2007, in PDF format (3MB)">2006-2007</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0506.pdf" title="Undergraduate Bulletin 2005-2006, in PDF format (3MB)">2005-2006</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0405.pdf" title="Undergraduate Bulletin 2004-2005, in PDF format (3.3MB)">2004-2005</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0304.pdf" title="Undergraduate Bulletin 2003-2004, in PDF format (2.8MB)">2003-2004</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0203.pdf" title="Undergraduate Bulletin 2002-2003, in PDF format (3MB)">2002-2003</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0102.pdf" title="Undergraduate Bulletin 2001-2002, in PDF format (7.8MB)">2001-2002</a></li>
                <li><a href="<?php echo $baseURL; ?>downloads/ugb0001.pdf" title="Undergraduate Bulletin 2000-2001, in PDF format (10.6MB)">2000-2001</a></li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
