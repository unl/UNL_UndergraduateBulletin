<?php

namespace UNL\UndergraduateBulletin\CachingService;

class Mock implements CachingServiceInterface
{
    /**
     * Callback function keys will be sent to
     *
     * @var Callback
     */
    public static $logger;

    public function get($key)
    {
        // Expired cache always.
        return false;
    }

    public function save($data, $key)
    {
        if (is_callable(static::$logger)) {
            call_user_func(static::$logger, $key);
        }

        // Make it appear as though it was saved.
        return true;
    }
}
