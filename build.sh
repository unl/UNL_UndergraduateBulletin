
echo "Rebuilding bulletin data"
php scripts/epub_to_xhtml.php

echo "Compressing CSS"
php scripts/compress.php

echo "Updating course DB"
php scripts/build_course_db.php

echo "Running tests..."

pyrus run-phpt -r tests
