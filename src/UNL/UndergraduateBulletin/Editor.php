<?php
class UNL_UndergraduateBulletin_Editor extends UNL_UndergraduateBulletin_LoginRequired
{
    protected static $auth;

    /**
     * The currently logged in user.
     *
     * @var false|string
     */
    protected static $user = false;

    function __postConstruct()
    {
    }

    /**
     * Log in the current user
     *
     * @return void
     */
    static function authenticate($logoutonly = false)
    {
        if (isset($_GET['logout'])) {
            self::$auth = UNL_Auth::factory('SimpleCAS');
            self::$auth->logout();
        }

        if ($logoutonly) {
            return true;
        }

        self::$auth = UNL_Auth::factory('SimpleCAS');
        self::$auth->login();

        if (!self::$auth->isLoggedIn()) {
            throw new Exception('You must log in to view this resource!', 403);
        }

        return self::$user;
    }

    /**
     * get the currently logged in user
     *
     * @return UNL_ENews_User
     */
    public static function get($forceAuth = false)
    {
        if (self::$user) {
            return self::$user;
        }

        if ($forceAuth) {
            self::authenticate();
        } elseif (self::isLoggedIn()) {
            self::$user = self::$auth->getUser();
        }

        return self::$user;
    }

    public static function isLoggedIn()
    {
        if (self::$auth === null) {
            self::$auth = UNL_Auth::factory('SimpleCAS');
        }
        return self::$auth->isLoggedIn();
    }

    /**
     * Set the currently logged in user
     *
     * @return string
     */
    public static function set($user)
    {
        self::$user = $user;
    }
}