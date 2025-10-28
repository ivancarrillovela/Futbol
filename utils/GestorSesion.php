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
