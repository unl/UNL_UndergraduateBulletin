<?php

namespace UNL\UndergraduateBulletin\College;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\EPUB\Utilities;

class Description
{
    protected $college;

    protected $description;

    protected $majors = [];

    protected $xml;

    public function __construct(College $college)
    {
        $this->college = $college;

        $file = Controller::getEdition()->getDataDir().'/colleges/'.$college->name.' Main Page.xhtml';

        if (!file_exists($file)) {
            throw new \Exception('No description for the "'.$college->name.'" college.', 404);
        }

        $this->xml = simplexml_load_string(file_get_contents($file));

        // Fetch all namespaces
        $namespaces = $this->xml->getNamespaces(true);
        $this->xml->registerXPathNamespace('default', $namespaces['']);

        // Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $this->xml->registerXPathNamespace($prefix, $ns);
        }

        $body = $this->xml->xpath('//default:body');

        $this->parseQuickPoints();

        $this->description = Utilities::format($body[0]->children()->asXML());
    }

    public function parseQuickPoints()
    {
        $quickpoints = $this->xml->xpath('//default:p[@class="quick-points"]');

        while (list( , $quickpoint) = each($quickpoints)) {
            // Handle quickpoint
            if (isset($quickpoint->span)) {
                $point_desc = (string)$quickpoint->span;
            } else {
                $point_desc = (string)$quickpoint;
            }
            if (preg_match('/([A-Z\s]+)+:/', $point_desc, $matches)) {
                $value = trim(str_replace($matches[0], '', (string)$quickpoint));

                switch ($matches[1]) {
                    case 'MAJORS':
                        $this->majors = explode(', ', $value);
                        asort($this->majors);
                        break;
                }
            }
        }
    }

    public function __isset($var)
    {
        switch ($var) {
            case 'description':
                return isset($this->description);
            case 'college':
                return isset($this->college);
            case 'majors':
                return isset($this->majors);
        }

        $nodes = $this->getContentSection($var);
        if (!$nodes) {
            return $nodes;
        }
        return (bool)count($nodes);
    }

    protected function getContentSection($section)
    {
        switch ($section) {
            case 'admissionRequirements':
                $section_title = 'ADMISSION';
                break;
            case 'bulletinRule':
                $section_title = 'BULLETIN TO USE';
                break;
            case 'other':
                $section_title = 'OTHER';
                break;
            case 'degreeRequirements':
                $section_title = 'COLLEGE DEGREE REQUIREMENTS';
                break;
            case 'aceRequirements':
                $section_title = 'ACE REQUIREMENTS';
                break;
            default:
                return false;
        }

        // first find the content box headings for the major page
        $nodes = $this->xml->xpath('//default:p[@class="content-box-m-p" and contains(.,"'.$section_title.'")]');

        return $nodes;
    }

    public function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->description;
            case 'college':
                return $this->college;
            case 'majors':
                return $this->majors;
        }

        // first find the content box headings for the major page
        $nodes = $this->getContentSection($var);

        if (!count($nodes)) {
            throw new \Exception('No college section '.$var.' found for '.$this->college->name);
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
                                return Utilities::format($content);
                        }
                    }
                }
            }

            // Add the raw xml of this sibling to the content we'll return.
            $content .= $sibling_node->asXML().PHP_EOL;
        }

        return Utilities::format($content);
    }

    public function __toString()
    {
        return $this->description;
    }
}
