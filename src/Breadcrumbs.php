<?php

namespace UNL\UndergraduateBulletin;

class Breadcrumbs
{
    protected $crumbs = [];

    public function addCrumb($title, $url = false)
    {
        $this->crumbs[] = [
            'title' => $title,
            'url' => $url,
        ];

        return $this;
    }

    public function getCrumbs()
    {
        return $this->crumbs;
    }
}
