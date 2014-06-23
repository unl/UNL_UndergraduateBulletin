# The UNL Undergraduate Bulletin

This is the source for the [UNL Undergraduate Bulletin website](http://bulletin.unl.edu/undergraduate/).

## SETUP

Required:
PHP 5.3 & Phar extension

The `www` dir is where the web files are stored, and should be the served root.
Copy the `www/sample.htaccess` to `www/.htaccess` and configure as necessary.
Copy the `config.sample.php` to `config.inc.php`.


## THE DATA

### Course Information
Course data is pulled from the creq.unl.edu web service and is cached within 
the `data/creq` directory. Run the `update_course_data.php` script to retrieve the latest course
data.

The XML follows a fairly straightforward schema. This application provides web services,
tied to each yearly bulletin/catalog edition, since the requirements and course descriptions change.

* http://bulletin.unl.edu/undergraduate/courses/TMFD/101
* http://bulletin.unl.edu/undergraduate/courses/TMFD/101?format=xml
* http://bulletin.unl.edu/undergraduate/courses/TMFD/101?format=json
* http://bulletin.unl.edu/undergraduate/courses/TMFD/101?format=partial

The "partial" output allows individual sites to pull in the content via an XMLHTTP request, and inject that HTML directly within their page(s). We send Cross Origin Resource Sharing headers, so the content can be included across different domains.

### Four Year Plans & Learning Outcomes

The Four Year Plan and Learning Outcome information comes from the Curriculum Request system as JSON data.
Run the `update_plan_data.php` or `update_learning_outcome_data.php` script to grab the latest information.

### College & Major Requirements Text
College, major, and minor information is stored in the `data` directory.

The XHTML files are edited through the Curriculum Request system, [creq.unl.edu](https://creq.unl.edu/).

The original source of these files was epub exports from Adobe InDesign.

## EDITION INFORMATION

Every edition is stored in a separate `data` directory, corresponding to the year of the fall term.
The 2012 directory is for the 2012-2013 bulletin year.

### New Editions

New editions are created by duplicating the folder for the current edition, to a new directory.
```bash
cp -rp data/2014 data/2015
git add data/2015
git commit -m "Create new edition"
```

There is a static file which contains the list of all the editions, and which one to consider the latest 
published edition: `src/UNL/UndergraduateBulletin/Editions.php`
Edit this file with the information on which bulletins exist, and which is the latest.

Once the new edition has been created, notify the Curriculum Request team.

Edits to the upcoming edition will come through in Pull Requests from the [Curriculum Request repo](https://github.com/unl-creq/UNL_UndergraduateBulletin/).

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
