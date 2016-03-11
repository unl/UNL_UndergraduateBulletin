<?php
/**
 * This file contains edition specific configuration
 */
UNL\UndergraduateBulletin\EPUB\Utilities::setEpubToTitleMap([
    // data/majors/{FILENAME}.xhtml => title displayed
    'Aerospace Studies_Air Force ROTC' => 'Aerospace Studies/Air Force ROTC',
    'Child_Youth & Family Studies Minor' => 'Child, Youth & Family Studies Minor',
    'Child_Youth & Family Studies_Jour & Mass Communications' => 'Child, Youth & Family Studies/Journalism & Mass Communications',
    'Hospitality_Restaurant & Tourism Management (CASNR)' => 'Hospitality, Restaurant & Tourism Management (CASNR)',
    'Hospitality_Restaurant & Tourism Management (CEHS)' => 'Hospitality, Restaurant & Tourism Management (CEHS)',
    'LGBTQ Sexuality Studies Minor' => 'Lesbian, Gay, Bisexual, Transgender, Queer/Sexuality Studies Minor',
    'Military Science_Army ROTC' => 'Military Science/Army ROTC',
    'Modern Languages-French German & Russian Minor (ENGR)' => 'Modern Languages-French, German & Russian Minor (ENGR)',
    'Naval Science_Naval ROTC' => 'Naval Science/Naval ROTC',
    'Public Policy Analysis_Program Eval Cert' => 'Public Policy Analysis & Program Evaluation Certification',
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
    'PACS'  => 'Public Affairs & Community Service',
];

UNL\UndergraduateBulletin\SubjectArea\Filter::$filteredCodes = ['IMBS', 'NURS', 'VMED'];
