<?php
/**
 * This file contains edition specific configuration
 */
UNL\UndergraduateBulletin\EPUB\Utilities::setEpubToTitleMap([
    // data/majors/{FILENAME}.xhtml => title displayed
    'Child Development_Early Childhood Education' => 'Child Development/Early Childhood Education',
    'Child_Youth & Family Studies Minor' => 'Child, Youth & Family Studies Minor',
    'Child_Youth & Family Studies_Jour & Mass Communications' => 'Child, Youth & Family Studies/Journalism & Mass Communications',
    'Elementary Education (K-6) & Deaf or Hard of Hearing Education PreProf' => 'Elementary Education (K-6) & Deaf or Hard of Hearing Education (Pre-Professional)',
    'English_Journalism & Mass Communication Education (7-12)' => 'English/Journalism & Mass Communication Education (7-12)',
    'Hospitality_Restaurant & Tourism Management (CASNR)' => 'Hospitality, Restaurant & Tourism Management (CASNR)',
    'Hospitality_Restaurant & Tourism Management (CEHS)' => 'Hospitality, Restaurant & Tourism Management (CEHS)',
    'LGBTQ Sexuality Studies Minor' => 'Lesbian, Gay, Bisexual, Transgender, Queer/Sexuality Studies Minor',
    'Mild_Moderate Disabilities Education (7-12)' => 'Mild/Moderate Disabilities Education (7-12)',
    'Modern Languages-French German & Russian Minor (ENGR)' => 'Modern Languages-French, German & Russian Minor (ENGR)',
    'Nutrition_Exercise & Health Sciences' => 'Nutrition, Exercise & Health Sciences',
    'PreHealth_PreLaw & Combined Degree Prog' => 'Pre-Health, Pre-Law and Combined Degree Programs',
    'Public Policy Analysis_Program Eval Cert' => 'Public Policy Analysis & Program Evaluation Certification',
    'Textiles_Merchandising & Fashion Design_Communications' => 'Textiles, Merchandising & Fashion Design/Communications',
    'Textiles_Merchandising & Fashion Design Minor (CEHS)' => 'Textiles, Merchandising & Fashion Design Minor (CEHS)',
    'Womens & Gender Studies' => 'Women\'s & Gender Studies',
]);

UNL\UndergraduateBulletin\College\Colleges::$colleges = [
    'CASNR' => 'Agricultural Sciences & Natural Resources',
    'ARCH'  => 'Architecture',
    'ASC'   => 'Arts & Sciences',
    'CBA'   => 'Business Administration',
    'CEHS'  => 'Education & Human Sciences',
    'ENG'   => 'Engineering',
    'EPAC'  => 'Exploratory & Pre-Professional Advising Center',
    'FPA'   => 'Fine & Performing Arts',
    'JMC'   => 'Journalism & Mass Communications',
    'LIB'   => 'Libraries',
    'OUE'   => 'Undergraduate Education',
    'PACS'  => 'Public Affairs & Community Service',
    'ROTC'  => 'Reserve Officers Training Corps (ROTC)',
];

UNL\UndergraduateBulletin\SubjectArea\Filter::$filteredCodes = ['IMBS', 'NURS', 'VMED'];
