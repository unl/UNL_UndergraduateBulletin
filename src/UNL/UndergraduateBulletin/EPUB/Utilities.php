<?php
/**
 * The EPUB files exported from InDesign contain simple markup with a few class names.
 * 
 * This class contains simple methods for linking URLs within the text, courses,
 * and other minor markup cleanup.
 * 
 * @author bbieber
 */
class UNL_UndergraduateBulletin_EPUB_Utilities
{
	/**
	 * Overall method which applies all formatting
	 * 
	 * @param string $html The markup
	 * 
	 * @return string html
	 */
    public static function format($html)
    {
        $html = self::convertHeadings($html);
        $html = self::addLeaders($html);
        $html = self::linkURLs($html);
        $html = self::addCourseLinks($html);
        return $html;
    }

    /**
     * Finds www.unl.edu and http://../ within the text and wraps it in an
     * anchor tag.
     * 
     * @param string $html The markup
     * 
     * @return string html
     */
    public static function linkURLs($html)
    {
        $html = preg_replace('/\s(www\.unl\.edu.*)/', ' http://$1', $html);
        return preg_replace_callback('/(http:\/\/[^<^\s]+)/', array('UNL_UndergraduateBulletin_EPUB_Utilities', 'linkHref'), $html);
    }
    
    public static function convertHeadings($html)
    {
        // trim off pointless "generated-style" spans
        $html = preg_replace('/<span class="generated-style">([^<]*)<\/span>/', '$1', $html);
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

    /**
     * Most majors contain simple tables in text with credits that add up to a total.
     * 
     * These "leaders" are used as a series of dots (broder-bottom: dotted..), 
     * which leads the user to the credits at the end of the line.
     * 
     * @param string $html Basic markup
     * 
     * @return string html
     */
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

    /**
     * Link courses found within the text
     * 
     * @param string   $text     Text to scan for links
     * @param callback $callback Method to call with matches
     */
    public static function addCourseLinks($text, $callback = null)
    {

    	if ($callback == null) {
    		$callback = array('UNL_UndergraduateBulletin_EPUB_Utilities', 'linkCourse');
    	}

        $text = preg_replace_callback('/'
            . "([A-Z]{3,4})             # subject code, eg: CSCE \n"
            . "("
                . "("
                    . "(,?\s+)          # eg: 340, 440 \n"
                    . "|(\/)            # eg: 340\/440 \n"
                    . "|(,?\ or\ )      # eg: , 340 or 440 \n"
                    . "|(,?\ and\ )     # eg: , 340 and 440 \n"
                    . "|(,?\ and\/or\ ) # eg: , 340 and\/or 440 \n"
                . ")"
                . "([0-9]{2,4}[A-Z]?)   # course number, with optional letter \n"
            . ")+"
            . "([\.\s\<\,\;\/\)]|$)     # characters which signal the end of a course sequence \n"
            . "/x",
            $callback, $text);

        return $text;
    }

    /**
     * callback for the linkURLs preg match function
     *
     * @param array $matches
     */
    public static function linkHref($matches)
    {
        $href      = $matches[0];
        $link_end  = '';
        $done      = false;
        while (!$done) {
            $last_char = substr($href, -1);
            switch ($last_char) {
                case '.':
                case ',':
                case ')':
                    $href = substr($href, 0, -1);
                    $link_end = $last_char . $link_end;
                    $done = false;
                    break;
                default:
                    $done = true;
            }
        }
        return '<a href="'.$href.'">'.$href.'</a>'.$link_end;
    }
    
    /**
     * callback for the course preg match function
     * 
     * @param array $matches [0] is the full match, [1] is the subject code.
     */
    public static function linkCourse($matches)
    {
    	
        switch($matches[1]) {
            case 'ACE':
            case 'ACT':
            case 'OEFL': // TOEFL
            case 'SAT':
            case 'CBA':
            case 'DMIN': // PUB ADMIN (UNO courses)
            case 'UNL':
            case 'OURS': // HOURS
            case 'OTAL': // TOTAL
            case 'IMUM': // MINIMUM 15 HOURS
                return $matches[0];
        }

        $matches[0] = preg_replace('/0?([0-9]{2,4}[A-Z]?)/', '<a class="course" href="'.UNL_UndergraduateBulletin_Controller::getURL().'courses/'.$matches[1].'/$1">$0</a>', $matches[0]);
        $matches[0] = preg_replace('/([A-Z]{3,4})\s+(\<a[^>]+\>)/', '$2$1 ', $matches[0]);

        return $matches[0];
    }
}
