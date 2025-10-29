<?php
    $dirHref = "/EjerciciosDWEB/Futbol";
?>

<head>
    <meta charset="utf-8">
    <title>Competición</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $dirHref . "/assets/bootstrap/css/bootstrap.min.css" ?>">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand ps-4" href="<?php echo $dirHref . "/index.php" ?>">
            <img src="<?php echo $dirHref . "/assets/images/ball_icon.png" ?>" alt="" style="height: 30px; width: auto;">
        </a>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $dirHref . "/app/Equipos.php" ?>">Equipos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $dirHref . "/app/Partidos.php" ?>">Partidos</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">