<?php

namespace UNL\UndergraduateBulletin\EPUB;

use UNL\UndergraduateBulletin\Controller;
use UNL\Services\CourseApproval\SubjectArea\SubjectArea;

/**
 * The EPUB files exported from InDesign contain simple markup with a few class names.
 *
 * This class contains simple methods for linking URLs within the text, courses,
 * and other minor markup cleanup.
 *
 * @author bbieber
 */
abstract class Utilities
{
    protected static $epubFiles = [
        // data/majors/{FILENAME}.xhtml => title displayed
    ];

    /**
     * Overall method which applies all formatting
     *
     * @param string $html The markup
     *
     * @return string html
     */
    public static function format($html)
    {
        $html = static::convertHeadings($html);
        $html = static::addLeaders($html);
        $html = static::linkURLs($html);
        $html = static::addCourseLinks($html, Controller::getURL());

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
        return preg_replace_callback('/(http:\/\/[^<^\s]+)/', [__CLASS__, 'linkHref'], $html);
    }

    public static function convertHeadings($html)
    {
        $replacements = [
            // trim off pointless "generated-style" spans
            '/<span class="generated-style">([^<]*)<\/span>/' => '$1',
            '/<p class="content-box-h-1"[^>]*>([^<]*)<\/p>/' => '<h2 class="content-box-h-1">$1</h2>',
            '/<p class="content-box-m-p"[^>]*>([^<]*)<\/p>/' => '<h2 class="content-box-m-p">$1</h2>',
            '/<p class="section-1"[^>]*>([^<]*)<\/p>/' => '<h3 class="section-1">$1</h3>',
            '/<p class="title-1"([^>]*)>([^<]*)<\/p>/' => '<h3 class="title-1"$1>$2</h3>',
            '/<p class="title-2"[^>]*>([^<]*)<\/p>/' => '<h4 class="title-2">$1</h4>',
            '/<p class="title-3"[^>]*>([^<]*)<\/p>/' => '<h5 class="title-3">$1</h5>',
            '/<p class="section-2"[^>]*>([^<]*)<\/p>/' => '<h4 class="section-2">$1</h4>',
            '/<p class="section-3"[^>]*>([^<]*)<\/p>/' => '<h5 class="section-3">$1</h5>',
            '/([\s]+)?\(([\s]+)?CONTENT BOX HEADING([\s]+)?\)/i' => '',
        ];

        $html = preg_replace(array_keys($replacements), array_values($replacements), $html);
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
        $html = preg_replace(
            '/<p class="(requirement-sec-1)"[^>]*>(.*)\s([\d]{2,3})[\s]*<\/p>/',
            '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span>'
                . '<span class="req_value">$3</span></p>',
            $html
        );
        $html = preg_replace(
            '/<p class="(requirement-sec-[1-4](?:\-(?:ledr|note))?)"[^>]*>(.*)\s([\d]{1,2}(?:\-[\d]{1,3})?)[\s]*<\/p>/',
            '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span>'
                . '<span class="req_value">$3</span></p>',
            $html
        );
        $html = preg_replace(
            '/<p class="(abbreviations-list)"[^>]*>(((\sor\s)?[^\s]+)+)\s([^<]*)(<span.*>.*<\/span>)?<\/p>/',
            '<p class="$1"><span class="req_desc">$2</span><span class="leader"></span>'
                . '<span class="req_value">$5 $6</span></p>',
            $html
        );
        return $html;
    }

    /**
     * Find courses found within the text
     *
     * @param string   $text     Text to scan for links
     * @param callback $callback Method to call with matches
     *
     * @return string
     */
    protected static function courseScanCallback($text, $callback)
    {
        $text = preg_replace_callback(
            '/'
            . "([A-Z]{3,4})             # subject code, eg: CSCE \n"
            . "("
                . "("
                    . "(,?\s+)          # eg: 340, 440 \n"
                    . "|(\/)            # eg: 340\/440 \n"
                    . "|(,?\ or\ )      # eg: , 340 or 440 \n"
                    . "|(,?\ \&(amp\;)?\ ) # eg: , 340 &amp; 440 \n"
                    . "|(,?\ and\ )     # eg: , 340 and 440 \n"
                    . "|(,?\ and\/or\ ) # eg: , 340 and\/or 440 \n"
                . ")"
                . "([0-9]{2,3}[A-Z]?)   # course number, with optional letter \n"
            . ")+"
            . "\b(?!<\w)     # the end of a word and not the start of HTML \n"
            . "/x",
            $callback,
            $text
        );

        return $text;
    }

    /**
     * Find courses within a block of raw text
     *
     * @param string $text Generic text with inline course data
     *
     * @return array Subject codes and course numbers, e.g. array('AGRO'=>array('153'))
     */
    public static function findCourses($text)
    {
        $courses = [];
        $callback = function ($matches) use (&$courses) {
            if (!static::isValidSubjectCode($matches[1])) {
                return;
            }

            $courseNumbers = [];
            preg_match_all('/0?([0-9]{2,4}[A-Z]?)/', $matches[0], $courseNumbers);

            foreach ($courseNumbers[0] as $courseNumber) {
                if (!isset($courses[$matches[1]]) || !in_array($courseNumber, $courses[$matches[1]])) {
                    $courses[$matches[1]][] = $courseNumber;
                }
            }
        };

        self::courseScanCallback($text, $callback);
        return $courses;
    }

    /**
     * Find MISSING courses within a block of raw text
     *
     * @param string $text Generic text with inline course references
     *
     * @return array Subject codes and course numbers, e.g. array('AGRO'=>array('153'))
     */
    public static function findUnknownCourses($text)
    {
        $missingCourses = [];

        foreach (static::findCourses($text) as $subjectCode => $courses) {
            try {
                $subject = new SubjectArea($subjectCode);
                foreach ($courses as $course) {
                    try {
                        // try and get the listing
                        $checkCourse = $subject->courses[$course];
                        unset($checkCourse);
                    } catch (\Exception $e) {
                        $missingCourses[$subjectCode][] =  $course;
                    }
                }
            } catch (\Exception $e) {
                // Missing subject code, all the courses are unknown
                $missingCourses[$subjectCode] = $courses;
            }
            unset($subject);
        }

        return $missingCourses;
    }

    /**
     * Link courses found within the text
     *
     * @param string   $text     Text to scan for links
     * @param string   $url      Base URL for call links
     */
    public static function addCourseLinks($text, $url = '')
    {
        return static::courseScanCallback($text, function ($matches) use ($url) {
            return static::linkCourse($matches, $url);
        });
    }

    /**
     * callback for the linkURLs preg match function
     *
     * @param array $matches
     */
    public static function linkHref($matches)
    {
        $href = $matches[0];
        $linkEnd = '';
        $done = false;

        while (!$done) {
            $last_char = substr($href, -1);
            switch ($last_char) {
                case '.':
                case ',':
                case ')':
                case ':':
                    $href = substr($href, 0, -1);
                    $linkEnd = $last_char . $linkEnd;
                    $done = false;
                    break;
                default:
                    $done = true;
            }
        }

        return '<a href="'.$href.'">'.$href.'</a>'.$linkEnd;
    }

    /**
     * callback for the course preg match function
     *
     * @param array $matches [0] is the full match, [1] is the subject code.
     */
    public static function linkCourse($matches, $url = false)
    {

        if (!static::isValidSubjectCode($matches[1])) {
            return $matches[0];
        }

        if (!$url) {
            $url = Controller::getURL();
        }

        $matches[0] = preg_replace(
            ['/0?([0-9]{2,4}[A-Z]?)/', '/([A-Z]{3,4})\s+(\<a[^>]+\>)/'],
            ['<a class="course" href="'.$url.'courses/'.$matches[1].'/$1">$0</a>', '$2$1 '],
            $matches[0]
        );

        return $matches[0];
    }

    /**
     * Check if a subject code is valid
     * @todo Check against official subject codes
     *
     * @param string $code Subject code, e.g. CSCE
     */
    public static function isValidSubjectCode($code)
    {
        switch ($code) {
            case 'ACE':
            case 'ACT':
            case 'GPA':
            case 'III':
            case 'OEFL': // TOEFL
            case 'SAT':
            case 'PKI': // PKI 201E, Omaha building address
            case 'CBA':
            case 'DMIN': // PUB ADMIN (UNO courses)
            case 'UNL':
            case 'OURS': // HOURS
            case 'OTAL': // TOTAL
            case 'IMUM': // MINIMUM 15 HOURS
                return false;
        }

        return true;
    }

    /**
     * Updates a subject's course number in the supplied string.
     *
     * @param string $subject
     * @param string $originalCourseNumeber
     * @param string $newCourseNumber
     * @return string
     */
    public static function updateCourseNumber($text, $subject, $originalCourseNumeber, $newCourseNumber)
    {
        return static::courseScanCallback($text, function ($matches) use (
            $subject,
            $originalCourseNumeber,
            $newCourseNumber
        ) {
            // needed for backwards compat with php 5.3
            $staticSelf = __CLASS__;

            if (!$staticSelf::isValidSubjectCode($matches[1]) || $matches[1] != $subject) {
                return $matches[0];
            }

            return preg_replace(
                '/(' . $originalCourseNumeber . ')([^0-9A-Z]|$)/',
                $newCourseNumber . '$2',
                $matches[0]
            );
        });
    }

    /**
     * Get the name of the content area by the filename
     *
     * The name of certain majors or content areas cannot be used in file names.
     * This function translates the filename to the name of the content region
     *
     * @return mixed
     */
    public static function getNameByFile($filename)
    {
        $filename = str_replace([
            Controller::getEdition()->getDataDir(),
            '/majors/',
            '/other/',
            '.xhtml'
        ], '', $filename);

        if (isset(static::$epubFiles[$filename])) {
            return static::$epubFiles[$filename];
        }

        return $filename;
    }

    /**
     * Set the filename map for content areas with special characters
     *
     * @param array $array
     */
    public static function setEpubToTitleMap($array)
    {
        static::$epubFiles = $array;
    }

    /**
     * Get the epub filename to title map
     *
     * @return array Associative array of [filename]=>[title]
     */
    public static function getEpubToTitleMap()
    {
        return static::$epubFiles;
    }

    /**
     * Get the base portion of the filename by the major name
     *
     * @param string $name The major name
     *
     * @return string
     */
    public static function getFilenameBaseByName($name)
    {
        if ($new = array_search($name, static::getEpubToTitleMap())) {
            $name = $new;
        }

        return $name;
    }

    /**
     * Get the EPUB/xhtml content filename with the name
     * @param string $name         Name of the major or other area
     * @param string $contentType The content type to search, majors|other|fouryearplans
     * @param string $extentsion   The filename extension to search for
     *
     * @throws Exception
     *
     * @return string
     */
    public static function getFileByName($name, $contentType = 'majors', $extension = 'xhtml')
    {

        $name = self::getFilenameBaseByName($name);
        $xhtml = Controller::getEdition()->getDataDir().'/'.$contentType.'/'.$name.'.'.$extension;

        if (!file_exists($xhtml)) {
            throw new \Exception('Sorry, no '.$contentType.' information exists for '.$name, 404);
        }

        return $xhtml;
    }
}
