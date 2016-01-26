<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\Controller;

abstract class Aliases
{
    /**
     * Get all the major aliases for this edition of the bulletin
     *
     * @return array('alias'=>array('Major1', 'Major2'))
     */
    public static function getAliases()
    {
        if ($json = file_get_contents(Controller::getEdition()->getDataDir() . '/major_aliases.json')) {
            $aliases = json_decode($json, true);
            return $aliases;
        }

        return [];
    }

    public static function search($query)
    {
        $aliases = static::getAliases();
        $query = strtolower($query);

        if (isset($aliases[$query])) {
            return $aliases[$query];
        }

        return [];
    }
}
