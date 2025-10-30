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

<div class="container my-5">
    <div class="text-center text-md-start">
        <h1 class="display-4 fw-bold text-success">Partidos</h1>
        <p class="text-muted fs-5">Visualiza los partidos de cada jornada y añade nuevos encuentros.</p>
    </div>

    <hr class="mb-5">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success bg-gradient text-white fs-5">
            <i class="bi bi-calendar-event-fill me-2"></i>
            Seleccionar Jornada
        </div>
        <div class="card-body p-4">
            <form action="Partidos.php" method="GET" class="d-flex flex-wrap gap-3 align-items-center">
                <label for="jornada_select" class="fw-bold fs-5 mb-0">Jornadas Actuales:</label>
                <select name="jornada" id="jornada_select" class="form-select form-select-lg w-auto" required>
                    <option value="">Seleccione...</option>
                    <?php
                    // Asumimos que $jornadas es un array de números de jornada
                    $max_jornada = empty($jornadas) ? 0 : max($jornadas);
                    for ($i = 1; $i <= $max_jornada; $i++) {
                        $selected = ($jornada_seleccionada == $i) ? ' selected' : '';
                        echo '<option value="' . $i . '"' . $selected . '>Jornada ' . $i . '</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-eye-fill me-1"></i>
                    Ver Partidos
                </button>
            </form>
        </div>
    </div>

    <div class="row g-5">

        <div class="col-lg-7">
            <?php

            if ($jornada_seleccionada) {
                echo '<div class="card shadow-sm">';
                echo '    <div class="card-header bg-success bg-gradient text-white fs-5">';
                echo '        <i class="bi bi-list-ul me-2"></i>';
                echo '        Partidos de la Jornada ' . htmlspecialchars($jornada_seleccionada);
                echo '    </div>';
                echo '    <div class="card-body p-0">';

                if (empty($partidos_jornada)) {
                    echo '<div class="alert alert-info d-flex align-items-center rounded-0 m-0" role="alert">';
                    echo '   <i class="bi bi-info-circle-fill me-2"></i>';
                    echo '   <div>No hay partidos registrados para esta jornada.</div>';
                    echo '</div>';
                } else {
                    echo '<ul class="list-group list-group-flush">';

                    foreach ($partidos_jornada as $partido) {
                        $local = htmlspecialchars($partido['nombre_local']);
                        $visitante = htmlspecialchars($partido['nombre_visitante']);
                        $resultado = htmlspecialchars($partido['resultado']);
                        $estadio = htmlspecialchars($partido['estadio_partido']);

                        echo '<li class="list-group-item p-3">';
                        echo '   <div class="d-flex justify-content-between align-items-center">';
                        // Lado izquierdo: Nombres y estadio
                        echo '     <div>';
                        echo '       <h5 class="mb-1 text-success fw-bold">';
                        echo '         <i class="bi bi-shield-shaded me-1 opacity-75"></i>';
                        echo '         ' . $local . ' vs ' . $visitante;
                        echo '       </h5>';
                        echo '       <small class="text-muted ms-4 ps-2">';
                        echo '         <i class="bi bi-building me-1 opacity-75"></i>';
                        echo '         Estadio: ' . $estadio;
                        echo '       </small>';
                        echo '     </div>';
                        // Lado derecho: Resultado como badge
                        echo '     <span class="badge bg-dark bg-gradient fs-4 rounded-pill px-3">';
                        echo '       ' . $resultado;
                        echo '     </span>';
                        echo '   </div>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                echo '    </div>'; // Cierre de .card-body
                echo '</div>'; // Cierre de .card

            } else {

                echo '<div class="card shadow-sm">';
                echo '    <div class="card-body text-center p-5">';
                echo '        <i class="bi bi-calendar-week-fill text-success display-3 opacity-50"></i>';
                echo '        <h3 class="mt-3 text-muted">No has seleccionado una jornada</h3>';
                echo '        <p class="fs-5 text-muted">Por favor, usa el selector de arriba para ver los partidos.</p>';
                echo '    </div>';
                echo '</div>';
            }

            ?>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success bg-gradient text-white fs-5">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Añadir Nuevo Partido
                </div>
                <div class="card-body p-4">
                    <?php
                    if (!empty($error)) {
                        // Alerta de error mejorada (con icono)
                        echo '<div class="alert alert-danger d-flex align-items-center" role="alert">';
                        echo '  <i class="bi bi-exclamation-triangle-fill me-2"></i>';
                        echo '  <div>' . htmlspecialchars($error) . '</div>';
                        echo '</div>';
                    }
                    ?>

                    <form action="Partidos.php" method="POST" class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="id_local" id="id_local" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach ($equipos as $e) {
                                        echo '<option value="' . htmlspecialchars($e['id_equipo']) . '">' . htmlspecialchars($e['nombre']) . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="id_local"><i class="bi bi-people-fill me-1"></i> Equipo Local</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="id_visitante" id="id_visitante" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach ($equipos as $e) {
                                        echo '<option value="' . htmlspecialchars($e['id_equipo']) . '">' . htmlspecialchars($e['nombre']) . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="id_visitante"><i class="bi bi-people-fill me-1"></i> Equipo Visitante</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" name="jornada" id="jornada" class="form-control" min="1" required
                                    placeholder="1"
                                    value="<?php echo htmlspecialchars($jornada_seleccionada ?? 1); ?>">
                                <label for="jornada"><i class="bi bi-list-ol me-1"></i> Jornada</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="resultado" id="resultado" class="form-select" required>
                                    <option value="1">1 (Local)</option>
                                    <option value="X">X (Empate)</option>
                                    <option value="2">2 (Visitante)</option>
                                </select>
                                <label for="resultado"><i class="bi bi-check-all me-1"></i> Resultado</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="estadio_partido" id="estadio_partido" class="form-control"
                                    required placeholder="Ej: Estadio del Local">
                                <label for="estadio_partido"><i class="bi bi-house-door me-1"></i> Estadio</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold">
                                <i class="bi bi-check-circle me-2"></i>
                                Añadir Partido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>