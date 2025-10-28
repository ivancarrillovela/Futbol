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

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo $dirHref . "/index.php" ?>">Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

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