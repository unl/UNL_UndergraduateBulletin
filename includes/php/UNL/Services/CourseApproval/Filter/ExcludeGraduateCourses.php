<?php
class UNL_Services_CourseApproval_Filter_ExcludeGraduateCourses extends FilterIterator
{
    function accept()
    {
        $course = $this->getInnerIterator()->current();
        foreach ($course->codes as $listing) {
            if ($listing->courseNumber < 500) {
                return true;
            }
        }

        return false;
    }
}