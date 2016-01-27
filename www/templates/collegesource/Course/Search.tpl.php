<?php

$subjectAreas = new UNL\UndergraduateBulletin\SubjectArea\SubjectAreas();
$edition = UNL\UndergraduateBulletin\Controller::getEdition();

// The following fields MUST appear in the export
// See: https://tes.collegesource.com/support/faq/TES_coursedataimport.asp
$fields = [
    'Edition',
    'Department',
    'DepartmentAbbr',
    'CourseCode',
    'CourseLabel',
    'CourseDescription',
    'Units',
    'LectureHours',
    'LabHours',
    'OtherHours',
    'Prerequisite',
    'Corequisite',
    'Recommended',
    'Offered',
    'GradeBasis',
];

$delimitArray($fields);

$baseCsvCourse = array_fill_keys($fields, '');

foreach ($context->results as $course) {
    $csvCourse = $baseCsvCourse;
    $csvCourse['Edition'] = $edition->getYear();
    $csvCourse['CourseLabel'] = $course->title;
    $csvCourse['CourseDescription'] = trim(str_replace(["\r", "\n"], ' ', strip_tags(html_entity_decode($course->description))));
    $csvCourse['Prerequisite'] = trim(str_replace(["\r", "\n"], ' ', strip_tags(html_entity_decode($course->prerequisite))));
    $csvCourse['Offered'] = implode(', ', $course->getTermsOffered());

    // we do not currently store Corequisite, Recommended information separately (ignore)

    if ($credits = $course->getCredits()) {
        if (isset($credits['Single Value'])) {
            $csvCourse['Units'] = $credits['Single Value'];
        } elseif (isset($credits['Lower Range Limit'])) {
            $csvCourse['Units'] = 'Range: ' . $credits['Lower Range Limit'] . '-';

            if (isset($credits['Upper Range Limit'])) {
                $csvCourse['Units'] .= $credits['Upper Range Limit'];
            }
        }

        // the limit values add too much data for the field

        // if (isset($credits['Per Semester Limit'])) {
        //     $csvCourse['Units'] .= sprintf(' (Semester Max: %d)', $credits['Per Semester Limit']);
        // }

        // if (isset($credits['Per Career Limit'])) {
        //     $csvCourse['Units'] .= sprintf(' (Degree Max: %d)', $credits['Per Career Limit']);
        // }
    }

    foreach ($course->getActivities() as $type => $activity) {
        $hourField = 'OtherHours';
        if ('lec' === $type) {
            $hourField = 'LectureHours';
        } elseif ('lab' === $type) {
            $hourField = 'LabHours';
        }

        if (!isset($activity->hours)) {
            if (isset($credits['Single Value'])) {
                $csvCourse[$hourField] += (int) $credits['Single Value'];
            }

            continue;
        }

        $csvCourse[$hourField] += (int) $activity->hours;
    }

    if (isset($course->gradingType) && 'unrestricted' !== (string) $course->gradingType) {
        $csvCourse['GradeBasis'] = (string) $course->gradingType;
    }

    foreach ($course->getCodes() as $listing) {
        $subject = (string)$listing->subjectArea;

        if (!isset($subjectAreas[$subject])) {
            //Skip because we do not have a title for the subject code.
            continue;
        }

        $csvCourse['Department']     = $subjectAreas[$subject];
        $csvCourse['DepartmentAbbr'] = $subject;
        $csvCourse['CourseCode']     = $subject . " " . (string)$listing->courseNumber;

        $delimitArray(array_intersect_key($csvCourse, $baseCsvCourse));
    }
}
