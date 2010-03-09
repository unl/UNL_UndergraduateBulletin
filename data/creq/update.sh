wget http://creq.unl.edu/courses/public-view/all-courses -O all-courses
grep "<subject>" all-courses | grep --regexp "[A-Z]\{3,4\}" -o | sort | uniq > subject_codes.csv
