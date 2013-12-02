<?php 
class UNL_Services_CourseApproval_XCRIService_MockService implements UNL_Services_CourseApproval_XCRIService
{    
    public $xml_header = '<?xml version="1.0" encoding="UTF-8"?>
<courses xmlns="http://courseapproval.unl.edu/courses" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://courseapproval.unl.edu/courses /schema/courses.xsd">';
    
    public $xml_footer = '</courses>';
    
    public $mock_data = array();
    
    function __construct()
    {

		$this->mock_data['MATH'] = <<<MATH
  <course>
    <title>Calculus for Managerial and Social Sciences</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>MATH</subject>
        <courseNumber>104</courseNumber>
        <courseGroup>Introductory Mathematics Courses</courseGroup>
      </courseCode>
      <courseCode type="crosslisting">
        <subject>MATH</subject>
        <courseNumber>104</courseNumber>
        <courseLetter>X</courseLetter>
      </courseCode>
    </courseCodes>
    <gradingType>unrestricted</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>1108</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">Appropriate placement exam score or a grade of P (pass), or C or better in MATH 101.</div>
    </prerequisite>
    <notes>
      <div xmlns="http://www.w3.org/1999/xhtml">Credit for both MATH 104 and 106 is not allowed.</div>
    </notes>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Rudiments of differential and integral calculus with applications to problems from business, economics, and social sciences.</div>
    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
      <deliveryMethod>Web</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Fall</term>
      <term>Spring</term>
      <term>Summer</term>
    </termsOffered>
    <activities/>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
    <aceOutcomes>
      <slo>3</slo>
    </aceOutcomes>
  </course>
MATH;
    	
        $this->mock_data['ENSC'] = <<<ENSC
  <course>
    <title>Energy in Perspective</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>ENSC</subject>
        <courseNumber>110</courseNumber>

      </courseCode>
    </courseCodes>
    <gradingType>letter grade only</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>20082</effectiveSemester>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Scientific principles and historical interpretation to place energy use in the context of pressing societal, environmental and climate issues.</div>

    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>

      <term>Fall</term>
    </termsOffered>
    <activities>
      <activity>
        <type>lec</type>
        <hours>3</hours>
      </activity>

    </activities>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
  </course>
ENSC;
        
        $this->mock_data['ACCT'] = <<<ACCT
<course>
    <title>Introductory Accounting I</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>ACCT</subject>
        <courseNumber>201</courseNumber>

      </courseCode>
    </courseCodes>
    <gradingType>letter grade only</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>20101</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">Math 104 with a grade of 'C' or better;  14 cr hrs at UNL with a 2.5 GPA.</div>

    </prerequisite>
    <notes>
      <div xmlns="http://www.w3.org/1999/xhtml">ACCT 201 is 'Letter grade only'.</div>
    </notes>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Fundamentals of accounting, reporting, and analysis to understand financial, managerial, and business concepts and practices. Provides foundation for advanced courses.</div>
    </description>
    <campuses>

      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Fall</term>

      <term>Spring</term>
      <term>Summer</term>
    </termsOffered>
    <activities>
      <activity>
        <type>lec</type>
        <hours>3</hours>

      </activity>
    </activities>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
  </course>
  <course>
    <title>Honors: Introductory Accounting I</title>

    <courseCodes>
      <courseCode type="home listing">
        <subject>ACCT</subject>
        <courseNumber>201</courseNumber>
        <courseLetter>H</courseLetter>
      </courseCode>
    </courseCodes>

    <gradingType>unrestricted</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>20081</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">Good standing in the University Honors Program or by invitation; freshman standing; 3.5 GPA over at least 14 credit hours earned at UNL.</div>
    </prerequisite>
    <description>

      <div xmlns="http://www.w3.org/1999/xhtml">For course description, see ACCT 201.</div>
    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>

    </deliveryMethods>
    <termsOffered>
      <term>Fall</term>
      <term>Spring</term>
      <term>Summer</term>
    </termsOffered>
    <activities>

      <activity>
        <type>lec</type>
      </activity>
    </activities>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
  </course>
ACCT;
        $this->mock_data['AECN'] = <<<AECN
  <course>
    <title>Agricultural Marketing in a Multinational Environment</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>AECN</subject>
        <courseNumber>425</courseNumber>
      </courseCode>
    </courseCodes>
    <gradingType>unrestricted</gradingType>
    <dfRemoval>true</dfRemoval>
    <effectiveSemester>20091</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">9 hrs agricultural economics and/or economics or permission.</div>
    </prerequisite>
    <notes>
      <div xmlns="http://www.w3.org/1999/xhtml">Capstone course.</div>
    </notes>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Systems approach to evaulating the effects of current domestic and international political and economic events on agricultural markets.</div>
    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Fall</term>
    </termsOffered>
    <activities/>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
    <aceOutcomes>
      <slo>9</slo>
      <slo>10</slo>
    </aceOutcomes>
  </course>
  <course>
    <title>Agricultural and Natural Resource Policy Analysis</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>AECN</subject>
        <courseNumber>445</courseNumber>
      </courseCode>
      <courseCode type="crosslisting">
        <subject>NREE</subject>
        <courseNumber>445</courseNumber>
      </courseCode>
    </courseCodes>
    <gradingType>unrestricted</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>20091</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">ECON 211; ECON 212 or AECN 141. ECON 311 and 312 recommended.</div>
    </prerequisite>
    <notes>
      <div xmlns="http://www.w3.org/1999/xhtml">Capstone course. <br/></div>
    </notes>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Introduction to the application of economic concepts and tools to the analysis and evaluation of public policies. Economic approaches to policy evaluation derived from welfare economics. Social benefit-cost analysis described and illustrated through applications to current agricultural and natural resource policy issues.</div>
    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Spring</term>
    </termsOffered>
    <activities>
      <activity>
        <type>lec</type>
        <hours>3</hours>
      </activity>
    </activities>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
    <aceOutcomes>
      <slo>8</slo>
      <slo>10</slo>
    </aceOutcomes>
  </course>
AECN;
        $this->mock_data['CSCE'] = <<<CSCE
  <course>
    <title>Introduction to Problem Solving with Computers</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>CSCE</subject>
        <courseNumber>150</courseNumber>
        <courseLetter>A</courseLetter>

      </courseCode>
    </courseCodes>
    <gradingType>unrestricted</gradingType>
    <dfRemoval>true</dfRemoval>
    <effectiveSemester>20083</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">Four years high school mathematics.</div>

    </prerequisite>
    <notes>
      <div xmlns="http://www.w3.org/1999/xhtml">
        <em>CSCE 150A is designed to develop skills in programming and problem solving to prepare for CSCE 155.</em>
        <em>CSCE 150A will not count toward the requirements for the major in computer science and computer engineering. </em>
        <em>
          <em>Credit towards the degree may be earned in only one of: CSCE 150A or CSCE 150E or CSCE 150M or CSCE 252A.</em>

        </em>
      </div>
    </notes>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Problem solving with a computer and programming fundamentals using a popular high-level language. Logic and functions that apply to computer science; elementary programming constructs, type, and algorithmic techniques.</div>
    </description>
    <campuses>
      <campus>UNL</campus>

    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Fall</term>
      <term>Spring</term>

      <term>Summer</term>
    </termsOffered>
    <activities>
      <activity>
        <type>lec</type>
        <hours>3</hours>
      </activity>

    </activities>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
  </course>
  <course>
    <title>Special Topics in Computer Science</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>CSCE</subject>
        <courseNumber>196</courseNumber>

      </courseCode>
    </courseCodes>
    <gradingType>unrestricted</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>20081</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">Permission.</div>

    </prerequisite>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Aspects of computers and computing for computer science and computer engineering majors and minors. Topics vary.</div>
    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>

      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Fall</term>
      <term>Spring</term>
      <term>Summer</term>
    </termsOffered>

    <activities/>
    <credits>
      <credit type="Lower Range Limit">1</credit>
      <credit type="Upper Range Limit">3</credit>
      <credit type="Per Semester Limit">6</credit>
    </credits>
  </course>
  <course>
    <title>Approximation of Functions</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>CSCE</subject>
        <courseNumber>441</courseNumber>
      </courseCode>
      <courseCode type="grad tie-in">
        <subject>CSCE</subject>
        <courseNumber>841</courseNumber>
      </courseCode>
      <courseCode type="crosslisting">
        <subject>MATH</subject>
        <courseNumber>441</courseNumber>
        <courseGroup>Advanced Mathematics Courses</courseGroup>
      </courseCode>
      <courseCode type="grad tie-in">
        <subject>MATH</subject>
        <courseNumber>841</courseNumber>
        <courseGroup>Advanced Mathematics Courses</courseGroup>
      </courseCode>
    </courseCodes>
    <gradingType>unrestricted</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>1078</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">A programming language, MATH 221 and 314.</div>
    </prerequisite>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Polynomial interpolation, uniform approximation, orthogonal polynomails, least-first-power approximation, polynomial and spline interpolation, approximation and interpolation by rational functions.</div>
    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Fall</term>
      <term>Spring</term>
      <term>Summer</term>
    </termsOffered>
    <activities>
      <activity>
        <type>lec</type>
        <hours>3</hours>
      </activity>
    </activities>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
  </course>
CSCE;
        $this->mock_data['NREE'] = <<<NREE
<course>
    <title>Agricultural and Natural Resource Policy Analysis</title>
    <courseCodes>
      <courseCode type="home listing">
        <subject>NREE</subject>
        <courseNumber>445</courseNumber>
      </courseCode>
      <courseCode type="crosslisting">
        <subject>NREE</subject>
        <courseNumber>845</courseNumber>
      </courseCode>
    </courseCodes>
    <gradingType>unrestricted</gradingType>
    <dfRemoval>false</dfRemoval>
    <effectiveSemester>20091</effectiveSemester>
    <prerequisite>
      <div xmlns="http://www.w3.org/1999/xhtml">ECON 211; ECON 212 or AECN 141. ECON 311 and 312 recommended.</div>
    </prerequisite>
    <notes>
      <div xmlns="http://www.w3.org/1999/xhtml">Capstone course. <br/></div>
    </notes>
    <description>
      <div xmlns="http://www.w3.org/1999/xhtml">Introduction to the application of economic concepts and tools to the analysis and evaluation of public policies. Economic approaches to policy evaluation derived from welfare economics. Social benefit-cost analysis described and illustrated through applications to current agricultural and natural resource policy issues.</div>
    </description>
    <campuses>
      <campus>UNL</campus>
    </campuses>
    <deliveryMethods>
      <deliveryMethod>Classroom</deliveryMethod>
    </deliveryMethods>
    <termsOffered>
      <term>Spring</term>
    </termsOffered>
    <activities>
      <activity>
        <type>lec</type>
        <hours>3</hours>
      </activity>
    </activities>
    <credits>
      <credit type="Single Value">3</credit>
    </credits>
    <aceOutcomes>
      <slo>8</slo>
      <slo>10</slo>
    </aceOutcomes>
  </course>
NREE;
    }
    
    function getAllCourses()
    {
        return $this->xml_header.implode($this->mock_data).$this->xml_footer;
    }
    
    function getSubjectArea($subjectarea)
    {
        if (!isset($this->mock_data[$subjectarea])) {
            throw new Exception('Could not get data.', 500);
        }
        
        return $this->xml_header.$this->mock_data[$subjectarea].$this->xml_footer;
    }
}
