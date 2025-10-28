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

<h3>Partidos de: <?php echo htmlspecialchars($nombre_equipo); ?></h3>
<hr>

<div class="list-group">
    <?php

    if (empty($partidos)) {
        echo '<div class="alert alert-info">Este equipo aún no ha jugado partidos.</div>';
    }

    ?>

    <?php

    foreach ($partidos as $partido) {
        $jornada = htmlspecialchars($partido['jornada']);
        $local = htmlspecialchars($partido['nombre_local']);
        $visitante = htmlspecialchars($partido['nombre_visitante']);
        $resultado = htmlspecialchars($partido['resultado']);
        $estadio = htmlspecialchars($partido['estadio_partido']);

        echo '<div class="list-group-item">';
        echo '    <h5 class="mb-1">Jornada ' . $jornada . '</h5>';
        echo '    <p class="mb-1">';
        echo '        ' . $local . ' vs ' . $visitante;
        echo '    </p>';
        echo '    <p><strong>Resultado: ' . $resultado . '</strong></p>';
        echo '    <small>Estadio: ' . $estadio . '</small>';
        echo '</div>';
    }

    ?>
</div>