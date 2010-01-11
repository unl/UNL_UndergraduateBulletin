<?php
class UNL_UndergraduateBulletin_College
{
    public $name;
    
    function __construct($name)
    {
        $this->name = $name;
        
        $this->file = dirname(__FILE__).'/../../data/colleges/CEHS.xhtml';
        // read the .epub file?
    }
    
    public static function convertEpub($html)
    {
        $html = preg_replace('/<p class="content-box-h-1">([^<]*)<\/p>/', '<h2 class="sec_header">$1</h2>', $html);
        $html = preg_replace('/<p class="section-1">([^<]*)<\/p>/', '<h3>$1</h3>', $html);
        $html = preg_replace('/<p class="section-2">([^<]*)<\/p>/', '<h4>$1</h4>', $html);
        $html = preg_replace('/<p class="section-3">([^<]*)<\/p>/', '<h5>$1</h5>', $html);
        $html = preg_replace('/([\s]+)?\(([\s]+)?CONTENT BOX HEADING([\s]+)?\)/i', '', $html);
        return $html;
    }
}