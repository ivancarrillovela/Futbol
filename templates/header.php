<?php

    $dirHref = "/EjerciciosDWEB/Futbol";

    $paginaActual = basename($_SERVER['PHP_SELF']);

?>

<head>
    <meta charset="utf-8">
    <title>Competición</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $dirHref . "/assets/bootstrap/css/bootstrap.min.css" ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-success bg-gradient shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo $dirHref . "/index.php" ?>">
            <img src="<?php echo $dirHref . "/assets/images/ball_icon.png" ?>" alt="Logo" style="height: 30px; width: auto;" class="d-inline-block align-text-top me-1">
            Liga de Futbol
        </a>

        <div id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($paginaActual == 'Equipos.php') ? 'active' : ''; ?>" href="<?php echo $dirHref . "/app/Equipos.php" ?>">
                        <i class="bi bi-people-fill me-1"></i>
                        Equipos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($paginaActual == 'Partidos.php') ? 'active' : ''; ?>" href="<?php echo $dirHref . "/app/Partidos.php" ?>">
                        <i class="bi bi-calendar-event-fill me-1"></i>
                        Partidos
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-4">