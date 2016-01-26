<?php

namespace UNL\UndergraduateBulletin\Major;

use UNL\UndergraduateBulletin\EPUB\Utilities;

trait JsonLoadedDataTrait
{
    use DataTrait;

    /**
     * Title of the major
     *
     * @var string
     */
    public $title;

    public function loadData()
    {
        $file = Utilities::getFileByName($this->title, static::CONTENT_TYPE, 'json');
        $data = [];

        if ($json = file_get_contents($file)) {
            $data = json_decode($json, true);
        }

        return $data;
    }
}
