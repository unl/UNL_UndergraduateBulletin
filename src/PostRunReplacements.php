<?php

namespace UNL\UndergraduateBulletin;

interface PostRunReplacements
{
    public static function setReplacementData($field, $data);
    public function postRun($data);
}
