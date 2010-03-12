<?php
UNL_Templates::$options['version']        = 3;
UNL_Templates::$options['sharedcodepath'] = dirname(__FILE__).'/sharedcode';

$url = UNL_UndergraduateBulletin_Controller::getURL();
$page = UNL_Templates::factory('Debug');
$page->doctitle     = '<title>UNL | Undergraduate Bulletin</title>';
$page->titlegraphic = '<h1>Undergraduate Bulletin 2010-2011</h1>';
$page->breadcrumbs  = '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
</ul>
';

$page->navlinks     = '
<ul>
    <li><a href="'.$url.'">Bulletin Home</a></li>
    <li><a href="'.$url.'major/">Majors</a>
        <ul>
            <li><a href="'.$url.'major/Architecture">Architecture</a></li>
            <li><a href="'.$url.'major/Agribusiness">Agribusiness</a></li>
        </ul>
    </li>
    <li><a href="#">Academic Policies</a>
    	<ul>
            <li><a href="#">Policy 1</a></li>
            <li><a href="#">Policy 2</a></li>
            <li><a href="#">Policy 3</a></li>
            <li><a href="#">Policy 4</a></li>
            <li><a href="#">Policy 5</a></li>
            <li><a href="#">Policy 6</a></li>
        </ul>
    </li>
    <li><a href="#">Academic Colleges</a>
    	<ul>
            <li><a href="'.$url.'college/Agricultural+Sciences+%26+Natural+Resources">Agricultural Sciences &amp; Natural Resources</a></li>
            <li><a href="'.$url.'college/Architecture">Architecture</a></li>
            <!--
            <li><a href="#">Arts &amp; Sciences</a></li>
            <li><a href="#">Business Adminsitration</a></li>
            <li><a href="#">Division of General Studies</a></li>
            -->
            <li><a href="'.$url.'college/Education+%26+Human+Sciences">Education &amp; Human Sciences</a></li>
            <!--
            <li><a href="#">Engineering</a></li>
            -->
            <li><a href="'.$url.'college/Fine+%26+Performing+Arts">Hixson-Lied College of Fine &amp; Performing Arts</a></li>
            <!--
            <li><a href="#">Journalism &amp; Mass Communications</a></li>
            -->
            <li><a href="'.$url.'college/Libraries">Libraries</a></li>
            <li><a href="'.$url.'college/Public+Affairs+%26+Community+Service">Public Affairs &amp; Community Service</a></li>
            <li><a href="'.$url.'college/Reserve+Officers%27+Training+Corps+%28ROTC%29">Reserve Officers\' Training Corps (ROTC)</a></li>
        </ul>
    </li>
    
</ul>';
$page->loadSharedCodeFiles();
$page->addStylesheet('/wdn/templates_3.0/css/content/forms.css');
$page->addStylesheet('/wdn/templates_3.0/css/content/notice.css');
$page->addStylesheet($url. 'templates/html/css/all.css');
$page->head .= '
<script type="text/javascript" src="'.$url.'templates/html/scripts/jQuery.toc.js"></script>
<script type="text/javascript" src="'.$url.'templates/html/scripts/all.js"></script>
';

$page->maincontentarea = '<div class="wdn_notice" id="officialMessage">
							<div class="minimize">
								<a href="#">Close message</a>
							</div>
							<div class="message">
								<h4>This is an official document</h4>
								<p>Students who enter a college within the University in the 2010 academic year are expected to complete the graduation requirements set forth by that college in this bulletin. <a href="#">More information on this policy.</a></p>
							</div>
						</div>';
$page->maincontentarea .= $savvy->render($context->output);

echo $page;
