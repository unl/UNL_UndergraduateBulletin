<?php

namespace UNL\UndergraduateBulletin;

use UNL\UndergraduateBulletin\Edition\Edition;
use UNL\UndergraduateBulletin\Edition\Editions;
use UNL\Services\CourseApproval\Data;

class Controller implements PostRunReplacements, CachingService\CacheableInterface
{
    /**
     * URL to this controller.
     *
     * @var string
     */
    public static $url = '';

    public static $newestUrl = 'http://bulletin.unl.edu/undergraduate/';

    public $output;

    public $options = [
        'view' => 'index', // The default from the viewMap
        'format' => 'html',  // The default output format
    ];

    /**
     * The edition we're currently controlling
     *
     * @var Edition
     */
    public static $edition;

    protected $viewMap = [
        'index' => 'Introduction',
        'general' => 'GeneralInformation',
        'otherarea' => 'OtherArea',
        'majors' => 'MajorList',
        'major' => 'Major',
        'majorlookup' => 'MajorLookup',
        'plans' => 'Major',
        'outcomes' => 'Major',
        'courses' => 'Major',
        'subject' => 'SubjectArea',
        'subjects' => 'SubjectAreas',
        'course' => 'Listing',
        'college' => 'College',
        'collegemajors' => 'College_Majors',
        'colleges' => 'CollegeList',
        'searchcourses' => 'CourseSearch',
        'searchmajors' => 'MajorSearch',
        'search' => 'Search',
        'bulletinrules' => 'BulletinRules',
        'editions' => 'Editions',
        'book' => 'Book',
        'developers' => 'Developers'
    ];

    protected static $replacementData = [];

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;

        if (!empty($this->options['year'])) {
            static::setEdition(new Edition($this->options));
        }
    }

    public function getCacheKey()
    {
        if ($this->output instanceof \Exception) {
            return false;
        }

        return serialize($this->options);
    }

    public function preRun($fromCache, \Savvy $savvy)
    {

    }

    public function run()
    {
        if (!empty($this->output)) {
            return;
        }

        try {
            if (!isset($this->viewMap[$this->options['view']])) {
                throw new Exception('Sorry, that view does not exist.', 404);
            }

            $outputModelClass = __NAMESPACE__ . '\\' . $this->viewMap[$this->options['view']];
            $outputModel = new $outputModelClass($this->options);

            if ($outputModel instanceof ControllerAwareInterface) {
                $outputModel->setController($this);
            }

            $this->output[] = $outputModel;
        } catch (\Exception $e) {
            $this->output[] = $e;
        }
    }

    public function outputException(\Exception $e)
    {
        static::resetReplacementData();
        $this->output = $e;
    }

    public static function setReplacementData($field, $data)
    {
        static::$replacementData[$field] = $data;
    }

    public static function resetReplacementData()
    {
        static::$replacementData = [];
    }

    public function postRun($data)
    {
        if (!empty(static::$replacementData['doctitle']) && strstr($data, '<title>')) {
            $data = preg_replace(
                '/<title>.*<\/title>/',
                '<title>'.static::$replacementData['doctitle'].'</title>',
                $data
            );
        }

        if (isset(static::$replacementData['head']) && strstr($data, '</head>')) {
            $data = str_replace('</head>', static::$replacementData['head'].'</head>', $data);
        }

        if (isset(static::$replacementData['breadcrumbs'])
            && strstr($data, '<!-- InstanceBeginEditable name="breadcrumbs" -->')
        ) {
            $start = strpos($data, '<!-- InstanceBeginEditable name="breadcrumbs" -->')
                + strlen('<!-- InstanceBeginEditable name="breadcrumbs" -->');
            $end = strpos($data, '<!-- InstanceEndEditable -->', $start);

            $data = substr($data, 0, $start).static::$replacementData['breadcrumbs'].substr($data, $end);
        }

        if (isset(static::$replacementData['pagetitle'])
            && strstr($data, '<!-- InstanceBeginEditable name="pagetitle" -->')
        ) {
            $start = strpos($data, '<!-- InstanceBeginEditable name="pagetitle" -->')
                + strlen('<!-- InstanceBeginEditable name="pagetitle" -->');
            $end = strpos($data, '<!-- InstanceEndEditable -->', $start);

            $data = substr($data, 0, $start).static::$replacementData['pagetitle'].substr($data, $end);
        }

        return $data;
    }

    /**
     * Get the URL for the system or a specific object this controller can display.
     *
     * @param mixed $mixed             Optional object to get a URL for.
     * @param array $additional_params Extra parameters to adjust the URL.
     *
     * @return string
     */
    public static function getURL($mixed = null, $additionalParams = [])
    {

        $url = static::getEdition()->getURL();

        if (!$additionalParams) {
            return $url;
        }

        return $url . '?' . http_build_query($additionalParams);
    }

    /**
     * Get the bulletin URL without any edition details.
     */
    public static function getBaseURL()
    {
        return static::$url;
    }

    public static function getDataDir()
    {
        return dirname(__DIR__) . '/data';
    }

    /**
     * Determine if the current url is out of date.
     *
     * @return bool True if out of date, False if newest.
     */
    public static function isArchived()
    {
        return !(static::$url == parse_url(static::$newestUrl, PHP_URL_PATH));
    }

    /**
     * Get the request uri for the current selected page and compile a URL to the
     * Newest URL with the same request uri.
     *
     * @return string. The url to the newest version.
     */
    public static function getNewestURL()
    {
        $newestURL = static::$newestUrl;
        $request = explode(static::$url, $_SERVER['REQUEST_URI']);

        if (isset($request[1])) {
            $newestURL = static::$newestUrl . $request[1];
        }

        return $newestURL;
    }

    /**
     * Gets the version of the bulletin.  Version = year in the url.
     *
     * @return Edition
     */
    public static function getEdition()
    {
        if (!isset(static::$edition)) {
            static::setEdition(Editions::getLatest());
        }

        return static::$edition;
    }

    /**
     * Set the current edition
     *
     * @param Edition $edition
     */
    public static function setEdition(Edition $edition)
    {
        $courseService = Data::getXCRIService();

        if ($courseService instanceof CourseDataDriver) {
            $courseService->setEdition($edition);
        }

        static::$edition = $edition;
        $edition->loadConfig();
    }
}
