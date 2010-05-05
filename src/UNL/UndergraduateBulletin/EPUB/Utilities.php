<?php
class UNL_UndergraduateBulletin_EPUB_Utilities
{
    public static function format($html)
    {
        $html = self::convertHeadings($html);
        $html = self::addLeaders($html);
        $html = self::linkURLs($html);
        $html = self::addCourseLinks($html);
        return $html;
    }
    
    public static function linkURLs($html)
    {
        return preg_replace_callback('/(http:\/\/[^<^\s]+)/', array('UNL_UndergraduateBulletin_EPUB_Utilities', 'linkHref'), $html);
    }
    
    public static function convertHeadings($html)
    {
        $html = preg_replace('/<p class="content-box-h-1">([^<]*)<\/p>/', '<h2 class="sec_header content-box-h-1">$1</h2>', $html);
        $html = preg_replace('/<p class="content-box-m-p">([^<]*)<\/p>/', '<h2 class="sec_header content-box-m-p">$1</h2>', $html);
        $html = preg_replace('/<p class="section-1">([^<]*)<\/p>/', '<h3 class="section-1">$1</h3>', $html);
        $html = preg_replace('/<p class="title-1">([^<]*)<\/p>/', '<h3 class="title-1">$1</h3>', $html);
        $html = preg_replace('/<p class="title-2">([^<]*)<\/p>/', '<h4 class="title-2">$1</h4>', $html);
        $html = preg_replace('/<p class="title-3">([^<]*)<\/p>/', '<h5 class="title-3">$1</h5>', $html);
        $html = preg_replace('/<p class="section-2">([^<]*)<\/p>/', '<h4 class="section-2">$1</h4>', $html);
        $html = preg_replace('/<p class="section-3">([^<]*)<\/p>/', '<h5 class="section-3">$1</h5>', $html);
        $html = preg_replace('/([\s]+)?\(([\s]+)?CONTENT BOX HEADING([\s]+)?\)/i', '', $html);
        $html = str_replace('<table>', '<table class="zentable cool">', $html);
        return $html;
    }
    
    public static function addLeaders($html)
    {
        $html = preg_replace('/<br \/>/', ' ', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-3])">(.*)\s([\d]{1,2})[\s]*<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-4]\-ledr)">(.*)\s([\d]{1,2})[\s]*<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-3]\-note)">(.*)\s([\d]{1,2})[\s]*<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-3])">(.*)\s([\d]{1,2}\-[\d]{1,2})[\s]*<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-4]\-ledr)">(.*)\s([\d]{1,2}\-[\d]{1,2})[\s]*<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-1)">(.*)\s([\d]{2,3})[\s]*<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        return $html;
    }
    
    public static function addCourseLinks($text)
    {
        
        $text = preg_replace_callback('/([A-Z]{3,4})(((,?\s+)|(,? or )|(\/)|(,? and ))([0-9]{3,4}[A-Z]?))+/', array('UNL_UndergraduateBulletin_EPUB_Utilities', 'linkCourse'), $text);

        return $text;
    }
    
    public static function linkHref($matches)
    {
        $href = $matches[0];
        $link_end = '';
        if (substr($href, -1) == '.') {
            $href = substr($href, 0, -1);
            $link_end = '.';
        }
        return '<a href="'.$href.'">'.$href.'</a>'.$link_end;
    }
    
    public static function linkCourse($matches)
    {
        $text = $matches[0];
        switch($matches[1]) {
            case 'ACE':
            case 'ACT':
            case 'OEFL':
            case 'SAT':
            case 'CBA':
            case 'UNL':
            case 'OURS':
                return $text;
        }

        $text = preg_replace('/([0-9]{2,3}[A-Z]?)/', '<a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/'.$matches[1].'/$1">$0</a>', $text);
        $text = preg_replace('/([A-Z]{3,4})\s+(\<a[^>]+\>)/', '$2$1 ', $text);

        return $text;
    }
}