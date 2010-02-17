<?php
class UNL_UndergraduateBulletin_EPUB_Utilities
{
    public static function convertHeadings($html)
    {
        $html = preg_replace('/<p class="content-box-h-1">([^<]*)<\/p>/', '<h2 class="sec_header">$1</h2>', $html);
        $html = preg_replace('/<p class="section-1">([^<]*)<\/p>/', '<h3>$1</h3>', $html);
        $html = preg_replace('/<p class="title-1">([^<]*)<\/p>/', '<h3>$1</h3>', $html);
        $html = preg_replace('/<p class="section-2">([^<]*)<\/p>/', '<h4>$1</h4>', $html);
        $html = preg_replace('/<p class="section-3">([^<]*)<\/p>/', '<h5>$1</h5>', $html);
        $html = preg_replace('/([\s]+)?\(([\s]+)?CONTENT BOX HEADING([\s]+)?\)/i', '', $html);
        return $html;
    }
    
    public static function addLeaders($html)
    {
        $html = preg_replace('/<br \/>/', ' ', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-3][\-]?)">([^<]*)\s([\d]{1,2})<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-3]\-bold)">([^<]*)\s([\d]{1,2})<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-3][\-]?)">([^<]*)\s([\d]{1,2}\-[\d]{1,2})<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        $html = preg_replace('/<p class="(requirement-sec-[1-3]\-bold)">([^<]*)\s([\d]{1,2}\-[\d]{1,2})<\/p>/', '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span><span class="req_value">$3</span></p>', $html);
        return $html;
    }
}