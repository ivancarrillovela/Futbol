<?php

$dir = __DIR__;

require_once $dir . "/../persistence/DAO/PartidoDAO.php";
require_once $dir . "/../persistence/DAO/EquipoDAO.php";
require_once $dir . "/../templates/header.php";

$error = "";
$partidos_jornada = [];
$partidoDAO = new PartidoDAO();
$equipoDAO = new EquipoDAO();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_local'])) {
    $id_local = $_POST['id_local'];
    $id_visitante = $_POST['id_visitante'];

    if ($id_local == $id_visitante) {
        $error = "El equipo local y visitante no pueden ser el mismo.";
    } else {
        if ($partidoDAO->checkPartidoExists($id_local, $id_visitante)) {
            $error = "Estos dos equipos no pueden volver a jugar ya que han jugado un partido anteriormente.";
        } else {
            $nuevoPartido = [
                'id_local' => $id_local,
                'id_visitante' => $id_visitante,
                'resultado' => $_POST['resultado'],
                'jornada' => $_POST['jornada'],
                'estadio_partido' => $_POST['estadio_partido']
            ];
            if (!$partidoDAO->insert($nuevoPartido)) {
                $error = "Error al guardar el partido.";
            } else {
                header("Location: Partidos.php?jornada=" . $_POST['jornada']);
                exit;
            }
        }
    }
}

// Lógica para MOSTRAR partidos de una jornada
$jornada_seleccionada = $_GET['jornada'] ?? null;
if ($jornada_seleccionada) {
    $partidos_jornada = $partidoDAO->selectByJornada($jornada_seleccionada);
}

// Datos para los formularios
$jornadas = $partidoDAO->getJornadas();
$equipos = $equipoDAO->selectAll();
?>

<h3>Gestión de Partidos</h3>
<hr>

<div class="card mb-4">
    <div class="card-header">Seleccionar Jornada</div>
    <div class="card-body">
        <form action="Partidos.php" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <label for="jornada_select" class="mr-2">Ver Jornada:</label>
                <select name="jornada" id="jornada_select" class="form-control">
                    <option value="">Seleccione...</option>
                    <?php

                    $max_jornada = empty($jornadas) ? 0 : max($jornadas);

                    for ($i = 1; $i <= $max_jornada + 5; $i++) {
                        $selected = ($jornada_seleccionada == $i) ? ' selected' : '';
                        echo '<option value="' . $i . '"' . $selected . '>Jornada ' . $i . '</option>';
                    }

                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Ver</button>
        </form>
    </div>
</div>

<?php

// Comprueba si se ha seleccionado una jornada
if ($jornada_seleccionada) {

    // Imprime el encabezado de la jornada
    echo '<h4>Partidos de la Jornada ' . htmlspecialchars($jornada_seleccionada) . '</h4>';

    // Inicia el contenedor del grupo de listas
    echo '<div class="list-group mb-4">';

    // Comprueba si hay partidos para esta jornada
    if (empty($partidos_jornada)) {
        // Si no hay partidos, muestra un mensaje informativo
        echo '<div class="alert alert-info">No hay partidos registrados para esta jornada.</div>';
    } else {
        // Si hay partidos, itera sobre cada uno
        foreach ($partidos_jornada as $partido) {
            // Sanitiza los datos para mostrarlos de forma segura
            $local = htmlspecialchars($partido['nombre_local']);
            $visitante = htmlspecialchars($partido['nombre_visitante']);
            $resultado = htmlspecialchars($partido['resultado']);
            $estadio = htmlspecialchars($partido['estadio_partido']);

            // Imprime el HTML para cada partido
            echo '<div class="list-group-item">';
            echo '    <h5 class="mb-1">' . $local . ' vs ' . $visitante . '</h5>';
            echo '    <p><strong>Resultado: ' . $resultado . '</strong></p>';
            echo '    <small>Estadio: ' . $estadio . '</small>';
            echo '</div>';
        }
    }
    echo '</div>';
}

?>


<div class="card mb-4">
    <div class="card-header">Añadir Nuevo Partido</div>
    <div class="card-body">
        <?php
        if (!empty($error)) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
        }
        ?>

        <form action="Partidos.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6 mb-3">
                    <label for="id_local">Equipo Local</label>
                    <select name="id_local" id="id_local" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php
                        foreach ($equipos as $e) {
                            echo '<option value="' . htmlspecialchars($e['id_equipo']) . '">' . htmlspecialchars($e['nombre']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="id_visitante">Equipo Visitante</label>
                    <select name="id_visitante" id="id_visitante" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php
                        foreach ($equipos as $e) {
                            echo '<option value="' . htmlspecialchars($e['id_equipo']) . '">' . htmlspecialchars($e['nombre']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4 mb-3">
                    <label for="jornada">Jornada</label>
                    <input type="number" name="jornada" id="jornada" class="form-control" min="1" required
                        value="<?php echo htmlspecialchars($jornada_seleccionada ?? 1); ?>">
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="resultado">Resultado (1, X, 2)</label>
                    <select name="resultado" id="resultado" class="form-control" required>
                        <option value="1">1</option>
                        <option value="X">X</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="estadio_partido">Estadio</label>
                    <input type="text" name="estadio_partido" id="estadio_partido" class="form-control" required
                        placeholder="Ej: Estadio del Local">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Añadir Partido</button>
        </form>
    </div>
</div>