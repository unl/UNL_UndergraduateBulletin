<?php
/* @var $context UNL_Services_CourseApproval_Course */

// Set a default value
$credits = 'N/A';

if (isset($context->credits)) {
    if (isset($context->credits['Single Value'])) {
        $credits = $context->credits['Single Value'];
    } elseif (isset($context->credits['Lower Range Limit'])) {
        if (isset($context->credits['Lower Range Limit'])) {
            $credits = $context->credits['Lower Range Limit'].'-';
        }
        if (isset($context->credits['Upper Range Limit'])) {
            $credits .= $context->credits['Upper Range Limit'].',';
        }
    }
    $credits = trim($credits, ', ');
    echo  '
    <tr class="credits">
        <td class="label">Credit Hours:</td>
        <td class="value">'.$credits.'</td>
    </tr>';
    if (isset($context->credits['Per Semester Limit'])) {
        echo  '
        <tr class="credits limits">
            <td class="label">Max credits per semester:</td>
            <td class="value">'.$context->credits['Per Semester Limit'].'</td>
        </tr>';
    }
    if (isset($context->credits['Per Career Limit'])) {
        echo  '
        <tr class="credits limits">
            <td class="label">Max credits per degree:</td>
            <td class="value">'.$context->credits['Per Career Limit'].'</td>
        </tr>';
    }

}
