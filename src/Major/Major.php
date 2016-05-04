<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;
use UNL\UndergraduateBulletin\ControllerAwareInterface;
use UNL\UndergraduateBulletin\CachingService\CacheableInterface;

class Major implements
    CacheableInterface,
    ControllerAwareInterface,
    \JsonSerializable
{

    public $title;

    public $options;

    /**
     *
     * @var UNL_UndergraduateBulletin_Major_Description
     */
    protected $description;

    protected $subjectareas;

    protected $controller;

    public function __construct($options = [])
    {
        if (isset($options['name'])) {
            $this->title = $options['name'];
        }
        $this->options = $options;
    }

    public function setController(Controller $controller)
    {
        $page = $controller->getOutputPage();
        $pageTitle = $controller->getOutputController()->escape($this->title);
        $titleContext = 'Undergraduate Bulletin';

        $page->doctitle = sprintf(
            '<title>%s | %s | University of Nebraska-Lincoln</title>',
            $pageTitle,
            $titleContext
        );

        $subhead = '';
        foreach ($this->getColleges() as $college) {
            $subhead .= $college->name.' ';
        }
        if ($subhead) {
            $subhead = '<span class="wdn-subhead">' . $controller->getOutputController()->escape($subhead) . '</span> ';
        }

        $page->pagetitle = '<h1>' . $subhead . $pageTitle . '</h1>';
        $page->breadcrumbs->addCrumb($pageTitle);

        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getCacheKey()
    {
        if (!isset($this->options['view'])) {
            // We're not sure what we're rendering here, do not cache
            return false;
        }

        return 'major'.$this->title.$this->options['view'].$this->options['format'];
    }

    public function preRun($fromCache, \Savvy $savvy)
    {
    }

    public function run()
    {
    }

    public function __get($var)
    {
        switch ($var) {
            case 'description':
                return $this->getDescription();
            case 'subjectareas':
                return $this->getSubjectAreas();
            case 'colleges':
                return $this->getColleges();
        }
        throw new Exception('Unknown member var! '.$var);
    }

    public function getDescription()
    {
        if (!$this->description) {
            $this->description = new Description($this);
        }
        return $this->description;
    }

    /**
     * Get all course subject areas associated with this major.
     *
     * @return SubjectAreas
     */
    public function getSubjectAreas()
    {
        if (!$this->subjectareas) {
            $this->subjectareas = new SubjectAreas($this);
        }
        return $this->subjectareas;
    }

    /**
     * Get the Four-Year-Plans associated with this major
     *
     * @return FourYearPlan\FourYearPlans
     */
    public function getFourYearPlans()
    {
        return new FourYearPlan\FourYearPlans($this->options);
    }

    /**
     * Get the Learning Outcomes associated with this major
     *
     * @return LearningOutcome\LearningOutcomes
     */
    public function getLearningOutcomes()
    {
        return new LearningOutcome\LearningOutcomes($this->options);
    }

    public function getColleges()
    {
        return $this->getDescription()->getColleges();
    }

    public function __isset($var)
    {
        switch ($var) {
            case 'description':
            case 'subjectareas':
            case 'colleges':
                return null !== $this->__get($var);
        }

        return false;
    }

    /**
     * Get major by name
     *
     * @param string $name Major name, e.g. Accounting
     *
     * @return self
     */
    public static function getByName($name)
    {
        $options = ['name' => $name];
        $major = new self($options);
        return $major;
    }

    public function minorAvailable()
    {
        if (isset($this->getDescription()->quickpoints['Minor Available'])) {
            if (preg_match('/^Yes/', $this->getDescription()->quickpoints['Minor Available'])) {
                return true;
            }
        }
        return false;
    }

    public function minorOnly()
    {
        if (strpos($this->title, 'Minor') !== false) {
            return true;
        }

        if (isset($this->getDescription()->quickpoints['Degree Offered'])
            && $this->getDescription()->quickpoints['Degree Offered'] == 'Minor only'
        ) {
            return true;
        }

        if (isset($this->getDescription()->quickpoints['Minor Only'])) {
            return true;
        }

        return false;
    }

    public function getURL()
    {
        $url = Controller::getURL();
        $url .= 'major/'.urlencode($this->title);
        return str_replace('%2F', '/', $url);
    }

    public function jsonSerialize()
    {
        $render = isset($this->options['view']) ? $this->options['view'] : 'major';

        switch ($render) {
            case 'major':
                return [
                    'title' => $this->title,
                    'minorAvailable' => $this->minorAvailable(),
                    'minorOnly' => $this->minorOnly(),
                    'college' => $this->getColleges(),
                    'uri' => $this->getURL(),
                ];
            case 'plans':
                return $this->getFourYearPlans();
            case 'outcomes':
                return $this->getLearningOutcomes();
            default:
                return $this->getSubjectAreas();
        }
    }
}
