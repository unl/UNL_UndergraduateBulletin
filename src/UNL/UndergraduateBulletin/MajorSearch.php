<?php
class UNL_UndergraduateBulletin_MajorSearch extends ArrayIterator
{
    public $options = array('q'=>'');
    
    function __construct($options = array())
    {
        $this->options = $options + $this->options;

        $this->options['q'] = str_replace(
            array('..', DIRECTORY_SEPARATOR),
            '', trim($this->options['q']));

        // Replace a few special characters with wildcards
        $query = str_replace(array('\'', ' & ', ' and '), '*', $this->options['q']);

        // Now make sure we're case insensitive
        $query = preg_replace_callback('/([a-z])/i', array($this, 'replaceCallback'), $query);

        // Find matches on the filesystem
        $majors = glob(UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/majors/*'.$query.'*.xhtml');

        // Find matching major aliases
        $aliases = UNL_UndergraduateBulletin_MajorAliases::search($this->options['q']);

        foreach ($aliases as $key => $alias) {
            $aliases[$key] = UNL_UndergraduateBulletin_Controller::getEdition()->getDataDir().'/majors/'.$alias.'.xhtml';
        }

        $majors = array_merge($majors, $aliases);
        usort($majors, function ($a, $b) {
            // trim .xhtml off the filename, then compare
            $a = substr($a, 0, -6);
            $b = substr($b, 0, -6);
            return $a > $b;
        });
        return parent::__construct(array_unique($majors));
    }
    
    function current()
    {
        $name = UNL_UndergraduateBulletin_EPUB_Utilities::getNameByFile(parent::current());
        return new UNL_UndergraduateBulletin_Major(array('name'=>$name));
    }
    
    function replaceCallback($matches)
    {
        return '['.strtolower($matches[0]).strtoupper($matches[0]).']';
    }
}
