<?php

namespace UNL\UndergraduateBulletin;

class GeneralInformation
{
    protected $domDocument;

    public function __construct()
    {
        $generalInfoFile = Controller::getEdition()->getDataDir().'/General Information.xhtml';

        if (!file_exists($generalInfoFile)) {
            throw new \Exception("Page not found", 404);
        }

        $this->domDocument = new \DOMDocument();
        $this->domDocument->loadHTMLFile($generalInfoFile);
    }

    public function getBody()
    {
        $body = $this->domDocument->getElementsByTagName('body');
        if (!isset($body[0])) {
            return '';
        }

        $body = $body[0];

        $domXPath = new \DOMXPath($this->domDocument);
        $nodes = $domXPath->query('//body//*');
        foreach ($nodes as $node) {
            if ($node instanceof \DOMElement) {
                foreach ($node->attributes as $attr) {
                    if ($attr->name == 'xml:lang') {
                        $node->removeAttributeNode($attr);
                    }
                }
            }
        }

        $output = '';
        foreach ($body->childNodes as $node) {
            $output .= $this->domDocument->saveHTML($node);
        }

        return EPUB\Utilities::format($output);
    }
}
