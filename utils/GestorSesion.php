<?php

/**
 * @author ivanc
 * 
 * Clase para gestionar la sesión de usuario de forma segura.
 * Proporciona métodos estáticos para iniciar, destruir y controlar la inactividad de la sesión,
 * ayudando a prevenir ataques como el secuestro de sesión (session hijacking).
 * @package utils
 */
class GestorSesion
{
    /**
     * Inicia una sesión de PHP si no hay una activa.
     * 
     * Comprueba el estado de la sesión y, si no hay ninguna iniciada, la inicia.
     * Este método es privado para ser utilizado solo dentro de esta clase, 
     * asegurando que la sesión se inicie de manera controlada.
     */

    const INACTIVITY_TIME = 60; // Tiempo de inactividad en segundos antes de destruir la sesión.

    private static function startSessionIfNotStarted()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Inicia la sesión y gestiona el tiempo de inactividad.
     * 
     * Si la sesión ha estado inactiva por más de 60 segundos,
     * la destruye y crea una nueva para prevenir secuestros de sesión.
     * Actualiza la marca de tiempo de la última actividad en cada llamada para mantener la sesión activa.
     */
    public static function startSession()
    {
        self::startSessionIfNotStarted();

        // Comprueba si ha pasado el tiempo de inactividad.
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > self::INACTIVITY_TIME)) {

            // Si ha pasado el tiempo, destruye la sesión actual.
            self::destroySession();
            // Inicia una nueva sesión limpia.
            self::startSessionIfNotStarted();
        }

        // Actualiza la marca de tiempo de la última actividad.
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    /**
     * Destruye la sesión actual de forma segura.
     * 
     * Limpia todas las variables de sesión, elimina la cookie de sesión del navegador
     * y finalmente destruye la sesión en el servidor para invalidarla por completo.
     * Al hacer esto en vez de solo destruir la sesión se ayuda a prevenir ataques de secuestro de sesión.
     */
    public static function destroySession()
    {
        self::startSessionIfNotStarted();

        // Vacía el array de sesión.
        $_SESSION = array();

        // Si existe una cookie de sesión, la elimina.
        if (session_id() != "" || isset($_COOKIE[session_name()])) {
            // Establece la cookie con una fecha de expiración en el pasado para que el navegador la elimine.
            setcookie(session_name(), '', time() - (new DateInterval('P30D'))->format('%s'), '/'); // Expira hace 30 días
        };

        // Destruye la sesión en el servidor.
        session_destroy();
    }
}
