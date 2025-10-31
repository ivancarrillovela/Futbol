<?php

/**
 * @author ivanc
 * 
 * Cabecera de la aplicación.
 * 
 * Este archivo contiene la sección <head> del HTML y la barra de navegación.
 * Se incluye en todas las páginas para mantener una estructura y apariencia consistentes.
 * Define los enlaces a los archivos CSS, el título de la página y la navegación principal.
 * 
 * @package templates
 */

// Directorio base para construir las URLs de los enlaces y recursos.
$dirHref = "/EjerciciosDWEB/Futbol";

// Obtiene el nombre del archivo de la página actual para resaltar el enlace activo en el nav.
$paginaActual = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Competición</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Enlace a la hoja de estilos de Bootstrap -->
    <link rel="stylesheet" href="<?php echo $dirHref . "/assets/bootstrap/css/bootstrap.min.css" ?>">

    <!-- Enlace a la hoja de estilos de Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<!-- El cuerpo de la página con clases de Bootstrap para asegurar que el pie de página se mantenga abajo -->

<body class="d-flex flex-column min-vh-100">

    <!-- Barra de navegación principal -->
    <nav class="navbar navbar-expand-md navbar-dark bg-success bg-gradient shadow-sm">
        <div class="container">
            <!-- Enlace principal al inicio con el logo -->
            <a class="navbar-brand fw-bold" href="<?php echo $dirHref . "/index.php" ?>">
                <img src="<?php echo $dirHref . "/assets/images/ball_icon.png" ?>" alt="Logo" style="height: 30px; width: auto;" class="d-inline-block align-text-top me-1">
                Liga de Futbol
            </a>

            <!-- Contenedor de los enlaces de navegación -->
            <div id="navbarMenu">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">

                    <!-- Enlace a la página de Equipos -->
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?php
                                                    // Añade la clase 'active' si la página actual es Equipos.php
                                                    echo ($paginaActual == 'Equipos.php') ? 'active' : '';
                                                    ?>" href="<?php echo $dirHref . "/app/Equipos.php" ?>">
                            <i class="bi bi-people-fill me-1"></i>
                            Equipos
                        </a>
                    </li>

                    <!-- Enlace a la página de Partidos -->
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?php
                                                    // Añade la clase 'active' si la página actual es Partidos.php
                                                    echo ($paginaActual == 'Partidos.php') ? 'active' : '';
                                                    ?>" href="<?php echo $dirHref . "/app/Partidos.php" ?>">
                            <i class="bi bi-calendar-event-fill me-1"></i>
                            Partidos
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>