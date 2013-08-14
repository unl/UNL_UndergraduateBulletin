# The UNL Undergraduate Bulletin

This is the source for the 2010-2011 UNL Undergraduate Bulletin website.

## SETUP

Required:
PHP 5.3 & Phar extension

The `www` dir is where the web files are stored, and should be the served root.
Copy the `www/sample.htaccess` to `www/.htaccess` and configure as necessary.
Copy the `config.sample.php` to `config.inc.php`.


## THE DATA

### Course Information
Course data is pulled from the creq.unl.edu web service and is cached within 
the `data/creq` directory. Run the `update.sh` script to retrieve the latest course
data.

The XML follows a fairly straightforward schema. This application provides web services,
tied to each yearly bulletin/catalog edition, since the requirements and course descriptions change.

* http://bulletin.unl.edu/undergraduate/courses/TMFD/101
* http://bulletin.unl.edu/undergraduate/courses/TMFD/101?format=xml
* http://bulletin.unl.edu/undergraduate/courses/TMFD/101?format=json
* http://bulletin.unl.edu/undergraduate/courses/TMFD/101?format=partial

The "partial" output allows individual sites to pull in the content via an XMLHTTP request, and inject that HTML directly within their page(s). We send Cross Origin Resource Sharing headers, so the content can be included across different domains.


### College & Major Requirements
College and major information is stored in the data directory and contains epub
exports from Adobe InDesign. Judy Anderson maintains the content for these 
files, and is repsonsible for updating them and re-exporting the epub files.

Once a new epub file is generated, simply drop it in the respective directory,
then run `php scripts/epub_to_xhtml.php` to convert the epub files to xhtml.


## CACHED OUTPUT

All output is cached within  a temp directory, such as 
`tmp/unlcache_5174748813ed8803e7651fae9d2d077f_*` files.

`tmpwatch` is a tool that can be used to clean out the cache on a regular basis.

Sample:
`sudo /usr/sbin/tmpwatch --force --mtime --nodirs 1 /var/www/html/bulletin.unl.edu/undergraduate/tmp  /var/www/html/bulletin.unl.edu/undergraduate/tmp/json`


## LIBRARIES
Libraries are bundled within the includes directory. This is a Pyrus controlled
registry of PEAR installable packages.

`php pyrus.phar includes list-packages`

The current bundled dependencies are:
```
channel phpsavant.com:
 Savvy
channel pear.unl.edu:
 UNL_Autoload
 UNL_Cache_Lite
 UNL_DWT
 UNL_Templates
```

To upgrade an individual package, use:
`php pyrus.phar includes upgrade unl/UNL_Autoload`
