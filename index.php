<?php

$dir = __DIR__;
require_once $dir . "/utils/GestorSesion.php";

GestorSesion::startSession(); 

if (isset($_SESSION['last_team_viewed_id'])) {
    $team_id = $_SESSION['last_team_viewed_id'];
    header("Location: app/PartidosEquipo.php?id=" . $team_id);
    exit;
} else {
    header("Location: app/Equipos.php");
    exit;
}

?>