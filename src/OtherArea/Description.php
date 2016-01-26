<?php

namespace UNL\UndergraduateBulletin\OtherArea;

use UNL\UndergraduateBulletin\EPUB\Utilities;

class Description
{
    protected $otherarea;

    protected $description;

    protected $xml;

    public function __construct(OtherArea $otherarea)
    {
        $this->otherarea = $otherarea;
        $file = Utilities::getFileByName($otherarea->name, 'other', 'xhtml');
        $this->xml = simplexml_load_string(file_get_contents($file));

        // Fetch all namespaces
        $namespaces = $this->xml->getNamespaces(true);
        $this->xml->registerXPathNamespace('default', $namespaces['']);

        // Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $this->xml->registerXPathNamespace($prefix, $ns);
        }

        $body = $this->xml->xpath('//default:body');

        $this->description = Utilities::format($body[0]->children()->asXML());
    }

    public function __toString()
    {
        return $this->description;
    }
}
