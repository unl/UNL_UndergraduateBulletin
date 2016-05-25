<?php

namespace UNL\UndergraduateBulletin;

use UNL\UndergraduateBulletin\Edition\NextGraduate;
use UNL\Services\CourseApproval\Data;
use UNL\Templates\Templates;

class GraduateController extends CatalogController
{
    public static $url = '';

    protected static $edition;

    protected $viewMap = [
        'index' => 'Introduction',
        'subject' => 'SubjectArea\\SubjectArea',
        'subjects' => 'SubjectArea\\SubjectAreas',
        'course' => 'Course\\Listing',
        'searchcourses' => 'Course\\Search',
        // 'developers' => 'Developers\\Developers',
    ];

    public function run()
    {
        parent::run();

        if ($this->output instanceof Introduction) {
            header('Location: http://www.unl.edu/gradstudies/bulletin');
            exit;
        }
    }

    public function setOutputController(OutputController $outputController = null)
    {
        if (!$outputController) {
            $outputController = new OutputController();
        }

        $templateMapper = $outputController->getClassToTemplateMapper();

        // Override controller template
        $templateMapper::$output_template[__NAMESPACE__ . '\\' . 'GraduateController'] = 'CatalogController';

        $this->outputController = $outputController;
        return $this;
    }

    public function getOutputPage()
    {
        if (!$this->page) {
            $page = parent::getOutputPage();
            $page->setParam('class', 'graduate-catalog ' . $page->getParams()['class']);
            $page->doctitle = '<title>Bulletins | University of Nebraska-Lincoln</title>';
            $page->titlegraphic = 'Bulletins';
            $page->pagetitle = '';
            $page->breadcrumbs = new Breadcrumbs();

            $this->page = $page;
        }

        return $this->page;
    }

    public static function getEdition()
    {
        if (!isset(static::$edition)) {
            static::setEdition(new NextGraduate());
        }

        return static::$edition;
    }
}
