<?php

namespace UNL\UndergraduateBulletin;

trait SelfIteratingJsonSerializationTrait
{
    public function jsonSerialize()
    {
        $items = [];
        foreach ($this as $item) {
            $items[] = $item;
        }

        return $items;
    }
}
