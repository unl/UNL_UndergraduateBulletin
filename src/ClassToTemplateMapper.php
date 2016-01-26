<?php

namespace UNL\UndergraduateBulletin;

class ClassToTemplateMapper extends \Savvy_ClassToTemplateMapper
{
    protected $removePrefixes = [
        __NAMESPACE__ . '\\',
        'UNL\\Services\\CourseApproval\\',
    ];

    public function map($class)
    {
        if (isset(self::$output_template[$class])) {
            $class = self::$output_template[$class];
        }

        $class = str_replace($this->removePrefixes, '', $class);

        return parent::map($class);
    }
}
