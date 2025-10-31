<?php

/**
 * @author ivanc
 * 
 * Este script gestiona la página de equipos de la competición.
 * Permite visualizar la lista de equipos existentes y añadir nuevos equipos a la base de datos.
 * Utiliza EquipoDAO para interactuar con la base de datos.
 */

// Directorio actual
$dir = __DIR__;

// Requerir dependencias
require_once $dir . "/../persistence/DAO/EquipoDAO.php";
require_once $dir . "/../templates/header.php";

// Inicializar variables
$error = "";
$dao = new EquipoDAO();

// Obtener todos los equipos
$equipos = $dao->selectAll();

// Si se ha enviado el formulario para añadir un nuevo equipo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    // Validar que los campos no estén vacíos
    if (!empty($_POST['nombre']) && !empty($_POST['estadio'])) {
        // Crear un array con los datos del nuevo equipo
        $nuevoEquipo = [
            'nombre' => $_POST['nombre'],
            'estadio' => $_POST['estadio']
        ];

        // Insertar el nuevo equipo en la base de datos
        if (!$dao->insert($nuevoEquipo)) {
            $error = "¡Error al añadir el equipo! Puede que el equipo ya exista.";
        }

        // Redirigir a la página de equipos para mostrar la lista actualizada
        header("Location: Equipos.php");
        exit;
    } else {
        $error = "Debes rellenar todos los campos.";
    }
}
?>

<div class="container my-5">
    <div class="text-center text-md-start">
        <h1 class="display-4 fw-bold text-success">Equipos</h1>
        <p class="text-muted fs-5">Visualiza los equipos participantes y añade nuevos competidores.</p>
    </div>

    <hr class="mb-5">

    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-success bg-gradient text-white fs-5">
                    <i class="bi bi-list-ul me-2"></i>
                    Equipos Participantes en la Competición
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php
                        // Si no hay equipos, mostrar un mensaje
                        if (empty($equipos)) {
                            echo '<li class="list-group-item text-muted fst-italic p-3">No hay equipos registrados.</li>';
                        } else {
                            // Si hay equipos, mostrarlos en una lista
                            foreach ($equipos as $equipo) {
                                echo '<li class="list-group-item list-group-item-action p-3">';
                                echo '  <div class="d-flex justify-content-between align-items-center">';
                                echo '      <div>';
                                // Usamos stretched-link para hacer que todo el <li> sea clickeable
                                echo '          <a href="PartidosEquipo.php?id=' . htmlspecialchars($equipo['id_equipo']) . '" class="text-success fw-bold text-decoration-none fs-5 stretched-link">';
                                echo '              <i class="bi bi-people-fill me-2 opacity-75"></i>'; // Icono de equipo
                                echo '              ' . htmlspecialchars($equipo['nombre']);
                                echo '          </a>';
                                echo '          <br>';
                                echo '          <small class="text-muted ms-4 ps-2">';
                                echo '              <i class="bi bi-building me-1 opacity-75"></i>'; // Icono de estadio
                                echo '              Estadio: ' . htmlspecialchars($equipo['estadio']);
                                echo '          </small>';
                                echo '      </div>';
                                echo '      <i class="bi bi-chevron-right text-success opacity-50"></i>'; // Flecha indicadora
                                echo '  </div>';
                                echo '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success bg-gradient text-white fs-5">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Añadir Nuevo Equipo
                </div>
                <div class="card-body p-4">
                    <?php
                    // Si hay un error, mostrarlo
                    if (!empty($error)) {
                        // Alerta de error mejorada con icono
                        echo '<div class="alert alert-danger d-flex align-items-center" role="alert">';
                        echo '  <i class="bi bi-exclamation-triangle-fill me-2"></i>';
                        echo '  <div>' . htmlspecialchars($error) . '</div>';
                        echo '</div>';
                    }
                    ?>

                    <form action="Equipos.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Equipo" required>
                            <label for="nombre">
                                <i class="bi bi-person-badge me-1"></i>
                                Nombre del Equipo
                            </label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" name="estadio" id="estadio" placeholder="Estadio" required>
                            <label for="estadio">
                                <i class="bi bi-house-door me-1"></i>
                                Estadio
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold">
                            <i class="bi bi-check-circle me-2"></i>
                            Añadir Equipo
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
// Incluye el footer
require_once $dir . "/../templates/footer.php";
?>
