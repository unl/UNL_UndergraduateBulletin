<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\EPUB\Utilities;

class Description
{
    /**
     * The major associated with this description
     * @var Major
     */
    protected $major;

    /**
     * An associative array of quickpoints about this major.
     *
     * @var array
     */
    protected $quickpoints = [];

    protected $description;

    /**
     * @var Colleges
     */
    protected $colleges;

    public function __construct(Major $major)
    {
        $this->major = $major;

        $this->parseEPUB($major->title);
    }

    public function __get($var)
    {
        switch ($var) {
            case 'major':
            case 'quickpoints':
            case 'description':
            case 'colleges':
                return $this->$var;
        }

        throw new \Exception('Variable not found');
    }

    public function __isset($var)
    {
        return isset($this->$var);
    }

    public function parseEPUB($title)
    {
        $file = static::getFileByName($title);

        if (!file_exists($file)) {
            throw new \Exception('The file '.$file.' for '.$title.' does not exist.', 404);
        }

        if (!$xhtml = file_get_contents($file)) {
            throw new \Exception('Could not open ' . $file, 404);
        }
        $simplexml = simplexml_load_string($xhtml);

        if (!$simplexml) {
            throw new \Exception('The file '.$file.' could not be parsed. Check for XML validity.', 500);
        }

        // Fetch all namespaces
        $namespaces = $simplexml->getNamespaces(true);
        $simplexml->registerXPathNamespace('default', $namespaces['']);

        // Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $simplexml->registerXPathNamespace($prefix, $ns);
        }

        $this->parseQuickPoints($simplexml);

        $body = $simplexml->xpath('//default:body');

        $this->description = Utilities::format($body[0]->children()->asXML());
    }

    public function parseQuickPoints($simplexml)
    {

        $quickpoints = $simplexml->xpath('//default:p[@class="quick-points"]');

        while (list( , $quickpoint) = each($quickpoints)) {
            // Handle quickpoint
            if (isset($quickpoint->span)) {
                $point_desc = (string)$quickpoint->span;
                if (count($quickpoint->span) == 2) {
                    $quickpoint = $quickpoint->span[1];
                }
            } else {
                $point_desc = (string)$quickpoint;
            }

            if (preg_match('/\s*([A-Z\s]+)+:/', $point_desc, $matches)) {
                $value = trim(str_replace($matches[0], '', (string)$quickpoint));
                $attr = $matches[1];

                switch ($attr) {
                    case 'COLLEGE':
                        $value = str_replace(
                            ['Hixson-Lied ', 'College of ', ' and '],
                            ['', '', ' & '],
                            $value
                        );

                        if ($value == 'CASNR') {
                            $value = 'Agricultural Sciences & Natural Resources';
                        }

                        $this->colleges = new Colleges(['colleges' => $value]);
                        break;
                    case 'MAJOR':
                        break;
                    case 'OFFERED':
                    case 'DEGREE OFFERED':
                    case 'DEGREES OFFERED':
                    case 'HOURS REQUIRED':
                    case 'MINOR AVAILABLE':
                    case 'CHIEF ADVISER':
                    case 'CHIEF ADVISERS':
                    case 'CHIEF ADVISOR':
                    case 'CHIEF ADVISORS':
                    case 'MINOR ONLY':
                    case 'DEPARTMENT':
                    case 'DEPARTMENTS':
                    case 'PROGRAM':
                    case 'DEGREE':
                    case 'ADVISERS':
                    case 'ADVISER':
                    case 'ADVISORS':
                    case 'ADVISOR':
                        $attr = explode(' ', strtolower($attr));
                        $attr = array_map('ucfirst', $attr);
                        $attr = implode(' ', $attr);
                        $this->quickpoints[$attr] = $value;
                        break;
                    case 'GPA':
                    case 'GPA REQUIRED':
                        $this->quickpoints['GPA Required'] = $value;
                        break;
                    case 'MINIMUM CUMULATIVE GPA':
                        $this->quickpoints['Minimum Cumulative GPA'] = $value;
                        break;
                    default:
                        throw new \Exception('Unknown quickpoint "'.$matches[0].'"');
                }
            }
        }
    }

    public function getColleges()
    {
        return $this->colleges;
    }

    public static function getFileByName($name)
    {
        return Utilities::getFileByName($name, 'majors', 'xhtml');
    }

    /**
     * Get the epub filename to title map
     *
     * @return array Associative array of [filename]=>[title]
     */
    public static function getEpubToTitleMap()
    {
        return Utilities::getEpubToTitleMap();
    }
}
