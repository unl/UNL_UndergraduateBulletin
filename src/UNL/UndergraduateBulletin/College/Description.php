<?php
class UNL_UndergraduateBulletin_College_Description
{
    public $college;
    
    public $description;
    
    public $majors = array();
    
    protected static $files = array(
        //'Education & Human Sciences'=>'CEHS.xhtml',
        'Education & Human Sciences' => 'CEHS.epub/OEBPS/College_Page_test-CEHS.xhtml',
        'Architecture'               => 'ARCH College.epub/OEBPS/ARCH_College.xhtml',
        'Agricultural Sciences & Natural Resources'=>'CASNR College Page.epub/OEBPS/CASNR_College_Page.xhtml',
    );
    
    function __construct(UNL_UndergraduateBulletin_College $college)
    {
        $this->college = $college;
        
        if (!isset(self::$files[$college->name])) {
            throw new Exception('No description for the '.$college->name.' college.');
        }
        $file = 'phar://'.dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/data/colleges/'.self::$files[$college->name];
        
        $simplexml = simplexml_load_string(file_get_contents($file));
        
        // Fetch all namespaces
        $namespaces = $simplexml->getNamespaces(true);
        $simplexml->registerXPathNamespace('default', $namespaces['']);
        
        // Register the rest with their prefixes
        foreach ($namespaces as $prefix => $ns) {
            $simplexml->registerXPathNamespace($prefix, $ns);
        }

        $body = $simplexml->xpath('//default:body');
        
        $this->parseQuickPoints($simplexml);

        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::convertHeadings($body[0]->asXML());
        $this->description = UNL_UndergraduateBulletin_EPUB_Utilities::addLeaders($this->description);
    }
    
    function parseQuickPoints($simplexml)
    {
        $quickpoints = $simplexml->xpath('//default:p[@class="quick-points"]');

        while (list( , $quickpoint) = each($quickpoints)) {
            // Handle quickpoint
            if (isset($quickpoint->span)) {
                $point_desc = (string)$quickpoint->span;
            } else {
                $point_desc = (string)$quickpoint;
            }
            if (preg_match('/([A-Z\s]+)+:/', $point_desc, $matches)) {
                $value = trim(str_replace($matches[0], '', (string)$quickpoint));
                switch($matches[1]) {
                    case 'MAJORS':
                        $this->majors = explode(', ', $value);
                        break;
                }
            }
        }
    }
    
    function __toString()
    {
        return $this->description;
    }
}