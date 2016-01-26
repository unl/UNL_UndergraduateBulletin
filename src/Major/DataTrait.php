<?php

namespace UNL\UndergraduateBulletin\Major;

trait DataTrait
{
    protected $data;

    public function set($data)
    {
        $this->data = $data;
    }
}
