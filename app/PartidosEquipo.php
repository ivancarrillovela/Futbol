<?php

/**
 * @author ivanc
 * 
 * Este script PHP se encarga de mostrar los partidos de un equipo de fútbol específico.
 * La página muestra el historial de partidos del equipo, obtenido a través de un ID de equipo
 * proporcionado por la URL (método GET). Además, guarda el equipo visitado en la sesión del usuario.
 */

// Define el directorio actual para facilitar la inclusión de archivos.
$dir = __DIR__;

// Requiere los archivos DAO para la manipulación de datos, el gestor de sesión y el encabezado de la página.
require_once $dir . "/../persistence/DAO/PartidoDAO.php";
require_once $dir . "/../persistence/DAO/EquipoDAO.php";
require_once $dir . "/../utils/GestorSesion.php";
require_once $dir . "/../templates/header.php";

// Validación del ID del equipo.
// Comprueba si el ID del equipo está presente en la URL y si es un valor numérico.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de equipo no válido.</div>";
    exit; // Termina la ejecución del script si el ID no es válido.
}

// Convierte el ID del equipo a un entero para mayor seguridad.
$id_equipo = (int)$_GET['id'];

// Gestión de la sesión: guarda el equipo actual como el último visitado.
// Esto permite una navegación más fluida para el usuario.
GestorSesion::startSession(); // Inicia o reanuda la sesión.
$_SESSION['last_team_viewed_id'] = $id_equipo;

// Creación de instancias de los DAO para acceder a la base de datos.
$partidoDAO = new PartidoDAO();
$equipoDAO = new EquipoDAO(); // Necesario para obtener el nombre del equipo.

// Búsqueda del nombre del equipo por su ID.
$equipo = $equipoDAO->selectById($id_equipo);

// Comprobación de si el equipo fue encontrado en la base de datos.
if ($equipo) {
    // Si se encuentra, se asigna el nombre a una variable.
    $nombre_equipo = $equipo['nombre'];
} else {
    // Si no se encuentra, se asigna un nombre por defecto y se muestra un error.
    $nombre_equipo = "Equipo Desconocido";
    echo "<div class='alert alert-danger'>Error: El equipo con ID $id_equipo no existe.</div>";
}

// Obtención de todos los partidos jugados por el equipo (tanto de local como de visitante).
$partidos = $partidoDAO->selectById($id_equipo);

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
                    // Comprueba si el equipo ha jugado algún partido.
                    if (empty($partidos)) {
                        // Si no hay partidos, muestra un mensaje informativo.
                        echo '<div class="alert alert-info d-flex align-items-center rounded-0 m-0" role="alert">';
                        echo '  <i class="bi bi-info-circle-fill me-2"></i>';
                        echo '  <div>Este equipo aún no ha jugado partidos.</div>';
                        echo '</div>';
                    } else {
                        // Si hay partidos, los muestra en una lista.
                        echo '<ul class="list-group list-group-flush">';

                        foreach ($partidos as $partido) {
                            // Sanitiza los datos para prevenir ataques XSS.
                            $jornada = htmlspecialchars($partido['jornada']);
                            $local = htmlspecialchars($partido['nombre_local']);
                            $visitante = htmlspecialchars($partido['nombre_visitante']);
                            $resultado = htmlspecialchars($partido['resultado']);
                            $estadio = htmlspecialchars($partido['estadio_partido']);

                            // Resalta el nombre del equipo actual en la lista de partidos.
                            $local_display = ($local == $nombre_equipo) ? "<strong>" . $local . "</strong>" : $local;
                            $visitante_display = ($visitante == $nombre_equipo) ? "<strong>" . $visitante . "</strong>" : $visitante;

                            // Imprime la estructura HTML para cada partido.
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

<?php
// Incluye el footer.
require_once $dir . "/../templates/footer.php";

?>
