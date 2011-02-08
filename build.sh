
echo "Rebuilding bulletin data"
php scripts/epub_to_xhtml.php


echo "Running tests..."

pyrus run-phpt -r tests
