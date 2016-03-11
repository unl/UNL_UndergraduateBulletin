<?php

namespace UNL\UndergraduateBulletin;

use UNL\UndergraduateBulletin\Edition\Edition;
use UNL\UndergraduateBulletin\Edition\Editions;
use UNL\Services\CourseApproval\Data;
use UNL\Templates\Templates;

class Controller implements
    CachingService\CacheableInterface
{
    /**
     * URL to this controller.
     *
     * @var string
     */
    public static $url = '';

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
    protected static $edition;

    protected $viewMap = [
        'index' => 'Introduction',
        'general' => 'GeneralInformation',
        'otherarea' => 'OtherArea\\OtherArea',
        'majors' => 'Major\\Majors',
        'major' => 'Major\\Major',
        'majorlookup' => 'Major\\Lookup',
        'plans' => 'Major\\Major',
        'outcomes' => 'Major\\Major',
        'courses' => 'Major\\Major',
        'subject' => 'SubjectArea\\SubjectArea',
        'subjects' => 'SubjectArea\\SubjectAreas',
        'course' => 'Course\\Listing',
        'college' => 'College\\College',
        'collegemajors' => 'College\\Majors',
        'colleges' => 'College\\Colleges',
        'searchcourses' => 'Course\\Search',
        'searchmajors' => 'Major\\Search',
        'search' => 'Search',
        'bulletinrules' => 'BulletinRules',
        'editions' => 'Edition\\Editions',
        'book' => 'Book',
        'developers' => 'Developers\\Developers'
    ];

    protected $outputController;

    protected $page;

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
                throw new \Exception('Sorry, that view does not exist.', 404);
            }

            $outputModelClass = __NAMESPACE__ . '\\' . $this->viewMap[$this->options['view']];
            $outputModel = new $outputModelClass($this->options);

            if ($outputModel instanceof ControllerAwareInterface) {
                $outputModel->setController($this);
            }

            $this->output = $outputModel;
        } catch (\Exception $e) {
            $this->outputException($e);
        }
    }

    public function setOutputController(OutputController $outputController = null)
    {
        if (!$outputController) {
            $outputController = new OutputController();
        }

        $this->outputController = $outputController;
        return $this;
    }

    public function getOutputController()
    {
        if (!$this->outputController) {
            $this->setOutputConroller();
        }

        return $this->outputController;
    }

    public function getOutputPage()
    {
        if (!$this->page) {
            $page = Templates::factory('Fixed', Templates::VERSION_4_1);

            $webRoot = dirname(__DIR__) . '/www';
            if (file_exists($webRoot . '/wdn/templates_4.1')) {
                $page->setLocalIncludePath($webRoot);
            }

            $page->setParam('class', 'page-' . $this->options['view']);
            $page->doctitle = '<title>Undergraduate Bulletin | University of Nebraska-Lincoln</title>';
            $page->affiliation = '';
            $page->titlegraphic = 'Undergraduate Bulletin ' . static::getEdition()->getRange();
            $page->pagetitle = '<h1>Your Undergraduate Bulletin</h1>';
            $page->breadcrumbs = new Breadcrumbs();
            $page->breadcrumbs->addCrumb('Undergraduate Bulletin', static::getURL());

            $this->page = $page;
        }

        return $this->page;
    }

    public function outputException(\Exception $e)
    {
        $this->output = $e;
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

        if ($mixed) {
            $url .= $mixed;
        }

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

        if ($courseService instanceof Course\DataDriver) {
            $courseService->setEdition($edition);
        }

        static::$edition = $edition;
        $edition->loadConfig();
    }
}
