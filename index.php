<?php

/**
 * @author ivanc
 * 
 * Este script es el punto de entrada de la aplicación.
 * 
 * Inicia la sesión y redirige al usuario a la página de equipos o a la página de partidos del último equipo visitado.
 */

// Directorio actual
$dir = __DIR__;
// Requerir el gestor de sesión
require_once $dir . "/utils/GestorSesion.php";

// Iniciar la sesión
GestorSesion::startSession();

// Si existe el último equipo visitado en la sesión, redirigir a la página de partidos de ese equipo
if (isset($_SESSION['last_team_viewed_id'])) {
    $team_id = $_SESSION['last_team_viewed_id'];
    header("Location: app/PartidosEquipo.php?id=" . $team_id);
} else {
    // Si no, redirigir a la página de equipos
    header("Location: app/Equipos.php");
}
