wget --no-check-certificate http://creq.unl.edu/courses/public-view/all-courses -O all-courses.xml
# don't update the subject codes, until we can merge with descriptions
#grep "<subject>" all-courses.xml | grep --regexp "[A-Z]\{3,4\}" -o | sort | uniq > subject_codes.csv
php update.php
