<?php

class GestorSesion
{
    private static function startSessionIfNotStarted()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function startSession()
    {
        self::startSessionIfNotStarted();

        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {

            self::destroySession();
            self::startSessionIfNotStarted();

        }

        $_SESSION['LAST_ACTIVITY'] = time();
    }

    public static function destroySession()
    {
        self::startSessionIfNotStarted();

        $_SESSION = array();

        if (session_id() != "" || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 2592000, '/');
        }

        session_destroy();
    }
}
