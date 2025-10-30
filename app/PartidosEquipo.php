<?php

$dir = __DIR__;

require_once $dir . "/../persistence/DAO/PartidoDAO.php";
require_once $dir . "/../persistence/DAO/EquipoDAO.php";
require_once $dir . "/../utils/GestorSesion.php";
require_once $dir . "/../templates/header.php";

// Validar ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de equipo no válido.</div>";
    require_once __DIR__ . "/../templates/footer.php";
    exit;
}

$id_equipo = (int)$_GET['id'];

// LÓGICA DE SESIÓN: Guardar este equipo como el último visto
GestorSesion::startSession(); // Inicia y asegura la sesión
$_SESSION['last_team_viewed_id'] = $id_equipo;

// Obtener datos
$partidoDAO = new PartidoDAO();
$equipoDAO = new EquipoDAO(); // Necesario para obtener el nombre del equipo

// Implementación de selectById en EquipoDAO sería útil aquí
// Por ahora, buscamos en el array completo
$equipos = $equipoDAO->selectAll();
$nombre_equipo = "Equipo no encontrado";

// Buscamos el nombre del equipo en el array
foreach ($equipos as $eq) {
    if ($eq['id_equipo'] == $id_equipo) {
        $nombre_equipo = $eq['nombre'];
        break;
    }
}

$partidos = $partidoDAO->selectByEquipoId($id_equipo);

?>

<div class="container my-5">
    <div class="text-center text-md-start">
        <h1 class="display-4 fw-bold text-success">
            Partidos del <?php echo htmlspecialchars($nombre_equipo); ?>
        </h1>
        <p class="text-muted fs-5">Historial de los partidos jugados por el <?php echo htmlspecialchars($nombre_equipo); ?></p>
    </div>

    <hr class="mb-5">

    <div class="mb-4">
        <a href="Equipos.php" class="btn btn-outline-success">
            <i class="bi bi-arrow-left-circle me-1"></i>
            Volver a Equipos
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-success bg-gradient text-white fs-5">
                    <i class="bi bi-list-ul me-2"></i>
                    Historial de Partidos
                </div>

                <div class="card-body p-0">
                    <?php
                    if (empty($partidos)) {
                        // Alerta por si el equipo no ha jugado partidos
                        echo '<div class="alert alert-info d-flex align-items-center rounded-0 m-0" role="alert">';
                        echo '  <i class="bi bi-info-circle-fill me-2"></i>';
                        echo '  <div>Este equipo aún no ha jugado partidos.</div>';
                        echo '</div>';
                    } else {
                        // Lista de Partidos
                        echo '<ul class="list-group list-group-flush">';

                        foreach ($partidos as $partido) {
                            $jornada = htmlspecialchars($partido['jornada']);
                            $local = htmlspecialchars($partido['nombre_local']);
                            $visitante = htmlspecialchars($partido['nombre_visitante']);
                            $resultado = htmlspecialchars($partido['resultado']);
                            $estadio = htmlspecialchars($partido['estadio_partido']);

                            // Resaltar el equipo actual en el enfrentamiento
                            $local_display = ($local == $nombre_equipo) ? "<strong>" . $local . "</strong>" : $local;
                            $visitante_display = ($visitante == $nombre_equipo) ? "<strong>" . $visitante . "</strong>" : $visitante;

                            // Imprimir el HTML del <li> usando echo
                            echo '<li class="list-group-item p-3">';
                            echo '  <div class="d-flex justify-content-between align-items-center">';
                            echo '      <div>';
                            echo '          <h5 class="mb-1 text-success fw-bold">';
                            echo '              <i class="bi bi-shield-shaded me-1 opacity-75"></i>';
                            echo '              ' . $local_display . ' vs ' . $visitante_display;
                            echo '          </h5>';
                            echo '          <small class="text-muted ms-4 ps-2 d-block">';
                            echo '              <i class="bi bi-list-ol me-1 opacity-75"></i>';
                            echo '              Jornada: ' . $jornada;
                            echo '          </small>';
                            echo '          <small class="text-muted ms-4 ps-2 d-block">';
                            echo '              <i class="bi bi-building me-1 opacity-75"></i>';
                            echo '              Estadio: ' . $estadio;
                            echo '          </small>';
                            echo '      </div>';
                            echo '      <span class="badge bg-dark bg-gradient fs-4 rounded-pill px-3">';
                            echo '          ' . $resultado;
                            echo '      </span>';
                            echo '  </div>';
                            echo '</li>';
                        }

                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>