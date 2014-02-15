<?php
class UNL_UndergraduateBulletin_OtherArea_Description
{
    public $otherarea;

    public $description;

    protected $_xml;

    public function __construct(UNL_UndergraduateBulletin_OtherArea $otherarea)
    {
        $this->otherarea = $otherarea;

        $file = UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/other/'.$otherarea->name.'.xhtml';

        if (!file_exists($file)) {
            throw new Exception('No description for the "'.$otherarea->name.'" area.', 404);
        }

        $this->_xml = simplexml_load_string(file_get_contents($file));

        // Fetch all namespaces
        $namespaces = $this->_xml->getNamespaces(true);
        $this->_xml->registerXPathNamespace('default', $namespaces['']);

        // Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $this->_xml->registerXPathNamespace($prefix, $ns);
        }

        $body = $this->_xml->xpath('//default:body');

        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::format($body[0]->children()->asXML());
    }

    public function __isset($var)
    {
        $nodes = $this->getContentSection($var);
        if (!$nodes) {
            return $nodes;
        }
        return (bool)count($nodes);
    }

    protected function getContentSection($section)
    {
        switch ($section) {
            //case 'admissionRequirements':
            //    $section_title = 'ADMISSION';
            //    break;
            default:
                return false;
        }
        // first find the content box headings for the major page
        $nodes = $this->_xml->xpath('//default:p[@class="content-box-m-p" and contains(.,"'.$section_title.'")]');

        return $nodes;
    }

    public function __get($var)
    {

        // first find the content box headings for the page
        $nodes = $this->getContentSection($var);

        if (!count($nodes)) {
            throw new Exception('No section '.$var.' found for '.$this->otherarea->name);
        }

        $content = '';
        // now loop through all following siblings until we find the next section
        foreach ($nodes[0]->xpath('following-sibling::*') as $sibling_node) {
            // Check to see if we've captured anything yet.
            if (!empty($content)) {
                // Loop through this node's attributes for the class
                foreach ($sibling_node->attributes() as $attr => $value) {
                    if ($attr == 'class') {
                        switch ($value) {
                            case 'content-box-h-1':
                            case 'content-box-m-p':
                                // We've found the next section, return the content
                                return UNL_UndergraduateBulletin_EPUB_Utilities::format($content);
                        }
                    }
                }
            }
            // Add the raw xml of this sibling to the content we'll return.
            $content .= $sibling_node->asXML().PHP_EOL;
        }
        return UNL_UndergraduateBulletin_EPUB_Utilities::format($content);

    }

    public function __toString()
    {
        return $this->description;
    }
}
