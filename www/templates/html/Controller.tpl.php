<?php
UNL_Templates::$options['version']        = 3;
UNL_Templates::$options['sharedcodepath'] = dirname(__FILE__).'/sharedcode';

$url     = UNL_UndergraduateBulletin_Controller::getURL();
$baseURL = UNL_UndergraduateBulletin_Controller::getBaseURL();
$page    = UNL_Templates::factory('Fixed');

$page->doctitle     = '<title>UNL | Undergraduate Bulletin</title>';
$page->titlegraphic = '<h1>Undergraduate Bulletin '.UNL_UndergraduateBulletin_Controller::getEdition()->getRange().'</h1>';
$page->breadcrumbs  = '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li>Undergraduate Bulletin</li>
</ul>
';

$page->navlinks     = '
<ul>
    <li><a href="'.$url.'major/">Majors</a>
        <ul>
            <li><a href="'.$url.'major/search">Search for a Major</a></li>
        </ul>
    </li>
    <li><a href="'.$url.'courses/">Courses</a>
        <ul>
            <li><a href="'.$url.'courses/search">Search for a Course</a></li>
            <li><a href="'.$url.'courses/">Course Abbreviations</a></li>
        </ul>
    </li>
    <li><a href="'.$url.'general">Academic Policies</a>
        <ul>
            <li><a href="'.$url.'general#admission-categories">Admission Categories</a></li>
            <li><a href="'.$url.'general#undergraduate-transfer-credit-policy">Transfer Credit Policy</a></li>
            <li><a href="'.$url.'general#graduation-requirements">Graduation Requirements</a></li>
            <li><a href="'.$url.'general#academic-policies-and-procedures">Academic Policies and Procedures</a></li>
        </ul>
    </li>
    <li><a href="'.$url.'college/">Academic Colleges</a>
        <ul>
            <li><a href="'.$url.'college/Agricultural+Sciences+%26+Natural+Resources">Agricultural Sciences &amp; Natural Resources</a></li>
            <li><a href="'.$url.'college/Architecture">Architecture</a></li>
            <li><a href="'.$url.'college/Arts+%26+Sciences">Arts &amp; Sciences</a></li>
            <li><a href="'.$url.'college/Business+Administration">Business Administration</a></li>
            <li><a href="'.$url.'college/Education+%26+Human+Sciences">Education &amp; Human Sciences</a></li>
            <li><a href="'.$url.'college/Engineering">Engineering</a></li>
            <li><a href="'.$url.'college/Fine+%26+Performing+Arts">Hixson-Lied College of Fine &amp; Performing Arts</a></li>
            <li><a href="'.$url.'college/Journalism+%26+Mass+Communications">Journalism &amp; Mass Communications</a></li>
            
        </ul>
    </li>
    <li><a href="#">Honors Programs</a>
        <ul>
            <li><a href="'.$url.'college/Office+of+Undergraduate+Studies#university-honors-program-">NU Honors Program</a></li>
            <li><a href="#">Jeffrey S. Raikes School of Computer Science and Management</a></li>
        </ul>
    </li>
    <li><a href="'.$url.'college/">Other Academic Units</a>
        <ul>
            <li><a href="'.$url.'college/Office+of+Undergraduate+Studies">Office of Undergraduate Studies</a></li>
            <li><a href="'.$url.'college/Division+of+General+Studies">Division of General Studies</a></li>
            <li><a href="'.$url.'college/Libraries">Libraries</a></li>
            <li><a href="'.$url.'college/Public+Affairs+%26+Community+Service">Public Affairs &amp; Community Service</a></li>
            <li><a href="'.$url.'college/Reserve+Officers+Training+Corps+%28ROTC%29">Reserve Officers Training Corps (ROTC)</a></li>
        </ul>
    </li>
    
</ul>';
$page->loadSharedCodeFiles();
$page->addStylesheet('/wdn/templates_3.0/css/content/notice.css');
$page->addStylesheet('/wdn/templates_3.0/css/content/zenform.css');
if (UNL_UndergraduateBulletin_OutputController::getCacheInterface() instanceof UNL_UnderGraduateBulletin_CacheInterface_Mock) {
    $page->addStylesheet($baseURL. 'templates/html/css/debug.css');
} else {
    $page->addStylesheet($baseURL. 'templates/html/css/all.css');
}
$page->addStyleSheet($baseURL . 'templates/html/css/print.css', 'print');

$page->head .= '
<script type="text/javascript">var UNL_UGB_URL = "'.$url.'";</script>
<script type="text/javascript" src="/wdn/templates_3.0/scripts/plugins/ui/jQuery.ui.js"></script>
<script type="text/javascript" src="'.$baseURL.'templates/html/scripts/jQuery.toc.js"></script>
<script type="text/javascript" src="'.$baseURL.'templates/html/scripts/bulletin.functions.js"></script>
<link rel="home" href="'.$url.'" />
<link rel="search" href="'.$url.'search/" />
<!-- '.md5($context->getRawObject()->getCacheKey()).' -->
';

if ($context->getEdition()->year > UNL_UndergraduateBulletin_Editions::getLatest()->year) {
    $page->head .= <<<UNPUBLISHED
    <meta name="robots" content="noindex" />
    <script type="text/javascript">
    WDN.jQuery(document).ready( function() {
        WDN.jQuery('#wdn_wrapper').before('<div id="testIndicator"></div>');
    });
    </script>
UNPUBLISHED;
}

$page->maincontentarea = '';
$page->maincontentarea .= $savvy->render($context->output);

$page->maincontentarea .= $savvy->render($context, 'EditionNotice.tpl.php');

echo $page;
