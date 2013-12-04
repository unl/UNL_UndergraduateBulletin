<?php
$url = UNL_UndergraduateBulletin_Controller::getURL();
UNL_UndergraduateBulletin_Controller::setReplacementData('doctitle', 'Academic Policies &amp; General Information | Undergraduate Bulletin | University of Nebraska-Lincoln');
UNL_UndergraduateBulletin_Controller::setReplacementData('pagetitle', '<h1>Academic Policies &amp; General Information</h1>');
UNL_UndergraduateBulletin_Controller::setReplacementData('breadcrumbs', '
<ul>
    <li><a href="http://www.unl.edu/">UNL</a></li>
    <li><a href="'.$url.'">Undergraduate Bulletin</a></li>
    <li>Academic Policies &amp; General Information</li>
</ul>');
?>

<div class="wdn-grid-set">
    <div class="bp1-wdn-col-three-fourths centered">
		<div id="toc_nav">
		    <a id="tocToggle" href="#">+</a>
		    <ol id="toc"><li>Intro</li></ol>
    		<div id="toc_major_name">General Information</div>
		</div>
	</div>
</div>

<div id="long_content">
<?php
$contents = file_get_contents(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/General Information.xhtml');

$xml = simplexml_load_string($contents);

// Fetch all namespaces
$namespaces = $xml->getNamespaces(true);
$xml->registerXPathNamespace('default', $namespaces['']);

// Register the rest with their prefixes
foreach ($namespaces as $prefix => $ns) {
    $xml->registerXPathNamespace($prefix, $ns);
}

$body = $xml->xpath('//default:body');
echo UNL_UndergraduateBulletin_EPUB_Utilities::format($body[0]->asXML());
?>
</div>
