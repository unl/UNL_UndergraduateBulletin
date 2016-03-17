<?php

namespace UNL\UndergraduateBulletin;

use UNL\UndergraduateBulletin\Edition\Next;
use UNL\Services\CourseApproval\Data;
use UNL\Templates\Templates;

class CatalogController extends Controller
{
    public static $url = '';

    /**
     * The edition we're currently controlling
     *
     * @var Edition
     */
    protected static $edition;

    protected $viewMap = [
        'index' => 'Introduction',
        'subject' => 'SubjectArea\\SubjectArea',
        'subjects' => 'SubjectArea\\SubjectAreas',
        'course' => 'Course\\Listing',
        'searchcourses' => 'Course\\Search',
        'developers' => 'Developers\\Developers',
    ];

    public function __construct($options = [])
    {
        $this->options = $options + $this->options;
    }

    public function setOutputController(OutputController $outputController = null)
    {
        if (!$outputController) {
            $outputController = new OutputController();
        }

        $templateMapper = $outputController->getClassToTemplateMapper();

        // Override index template
        $templateMapper::$output_template[__NAMESPACE__ . '\\' . 'Introduction'] = 'Landing';

        $this->outputController = $outputController;
        return $this;
    }

    public function getOutputPage()
    {
        if (!$this->page) {
            $page = parent::getOutputPage();
            $page->doctitle = '<title>Bulletins | University of Nebraska-Lincoln</title>';
            $page->titlegraphic = 'Bulletins';
            $page->pagetitle = '';
            $page->breadcrumbs = new Breadcrumbs();

            $this->page = $page;
        }

        return $this->page;
    }

    /**
     * Gets the version of the bulletin.  Version = year in the url.
     *
     * @return Edition
     */
    public static function getEdition()
    {
        if (!isset(static::$edition)) {
            static::setEdition(new Next());
        }

        return static::$edition;
    }
}
