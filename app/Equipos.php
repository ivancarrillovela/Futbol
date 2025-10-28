<?php

$dir = __DIR__;

require_once $dir . "/../persistence/DAO/EquipoDAO.php";
require_once $dir . "/../templates/header.php";

$error = "";
$dao = new EquipoDAO();
 
$equipos = $dao->selectAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['estadio'])) {
        $nuevoEquipo = [
            'nombre' => $_POST['nombre'],
            'estadio' => $_POST['estadio']
        ];

        if (!$dao->insert($nuevoEquipo)) {
            $error = "¡Error al añadir el equipo! Puede que el equipo ya exista.";
        }

        header("Location: Equipos.php");
        exit;
    } else {
        $error = "Debe rellenar todos los campos.";
    }
}
?>

<h3>Gestión de Equipos</h3>
<hr>

<div class="card mb-4">
    <div class="card-header">Equipos Participantes en la Competición</div>
    <div class="card-body">
        <ul class="list-group">
            <?php

            foreach ($equipos as $equipo) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo '    <div>';
                echo '        <a href="PartidosEquipo.php?id=' . htmlspecialchars($equipo['id_equipo']) . '">';
                echo '            <strong>' . htmlspecialchars($equipo['nombre']) . '</strong>';
                echo '        </a>';
                echo '        <br>';
                echo '        <small>Estadio: ' . htmlspecialchars($equipo['estadio']) . '</small>';
                echo '    </div>';
                echo '</li>';
            }

            if (empty($equipos)) {
                echo '<li class="list-group-item">No hay equipos registrados.</li>';
            }

            ?>
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-header">Añadir Nuevo Equipo</div>
    <div class="card-body">
        <?php

            if (!empty($error)) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }

        ?>
        <form action="Equipos.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre del Equipo</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="estadio">Estadio</label>
                    <input type="text" class="form-control" name="estadio" id="estadio" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Añadir Equipo</button>
        </form>
    </div>
</div>