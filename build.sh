
echo "Rebuilding bulletin data"
php scripts/epub_to_xhtml.php

echo "Compressing CSS"
php scripts/compress.php

echo "Updating course data"
php scripts/update_course_data.php

echo "Running tests..."

pyrus run-phpt -r tests
