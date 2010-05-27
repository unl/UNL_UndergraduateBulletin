<?php

interface UNL_UndergraduateBulletin_PostRunReplacements
{
    static function setReplacementData($field, $data);
    public function postRun($data);
}
