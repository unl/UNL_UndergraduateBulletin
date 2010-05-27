<?php
require_once dirname(__FILE__).'/../test_framework.php.inc';

UNL_Services_CourseApproval::setCachingService(new UNL_Services_CourseApproval_CachingService_Null());
UNL_Services_CourseApproval::setXCRIService(new UNL_Services_CourseApproval_XCRIService_MockService());

