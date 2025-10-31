<?php

/**
 * @author ivanc
 * 
 * DAO para la tabla de partidos.
 * Hereda de GenericDAO y proporciona los métodos para realizar operaciones CRUD
 * (Crear, Leer, Actualizar, Borrar) y otras consultas específicas para la tabla de partidos.
 */

require_once 'GenericDAO.php';

class PartidoDAO extends GenericDAO
{

    /**
     * Constante que almacena el nombre de la tabla de partidos.
     */
    const PARTIDO_TABLE = 'partidos';

    /**
     * Selecciona todos los partidos registrados en la base de datos.
     *
     * @return array Un array de arrays asociativos, donde cada array representa un partido.
     */
    public function selectAll()
    {
        $query = "SELECT * FROM " . self::PARTIDO_TABLE;
        $result = mysqli_query($this->conn, $query);
        $partidos = array();
        while ($partidoDB = mysqli_fetch_array($result)) {
            $partido = array(
                'id_partido' => $partidoDB["id_partido"],
                'id_local' => $partidoDB["id_local"],
                'id_visitante' => $partidoDB["id_visitante"],
                'resultado' => $partidoDB["resultado"],
                'jornada' => $partidoDB["jornada"],
                'estadio_partido' => $partidoDB["estadio_partido"],
            );
            array_push($partidos, $partido);
        }
        return $partidos;
    }

    /**
     * Selecciona todos los partidos de un equipo específico, ya sea como local o como visitante.
     *
     * @param int $id_equipo El ID del equipo a buscar.
     * @return array Un array de partidos, incluyendo los nombres de los equipos local y visitante.
     */
    public function selectById($id_equipo)
    {
        $query = "SELECT p.*, el.nombre as nombre_local, ev.nombre as nombre_visitante 
              FROM " . self::PARTIDO_TABLE . " p
              JOIN equipos el ON p.id_local = el.id_equipo
              JOIN equipos ev ON p.id_visitante = ev.id_equipo
              WHERE p.id_local = ? OR p.id_visitante = ?
              ORDER BY p.jornada ASC";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $id_equipo, $id_equipo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = array();
        while ($partidoDB = mysqli_fetch_assoc($result)) {
            array_push($partidos, $partidoDB);
        }
        return $partidos;
    }

    /**
     * Inserta un nuevo partido en la base de datos.
     *
     * @param array $dto Un array asociativo con los datos del partido a insertar.
     * @return bool Devuelve true si la inserción fue exitosa, false en caso contrario.
     */
    public function insert($dto)
    {
        // El array $dto debe contener: ['id_local', 'id_visitante', 'resultado', 'jornada', 'estadio_partido']
        $query = "INSERT INTO " . self::PARTIDO_TABLE .
            " (id_local, id_visitante, resultado, jornada, estadio_partido) VALUES(?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param(
            $stmt,
            'iisis',
            $dto['id_local'],
            $dto['id_visitante'],
            $dto['resultado'],
            $dto['jornada'],
            $dto['estadio_partido']
        );
        return $stmt->execute();
    }

    /**
     * Selecciona todos los partidos correspondientes a una jornada específica.
     *
     * @param int $jornada El número de la jornada a consultar.
     * @return array Un array de partidos para la jornada especificada.
     */
    public function selectByJornada($jornada)
    {
        $query = "SELECT p.*, el.nombre as nombre_local, ev.nombre as nombre_visitante 
              FROM " . self::PARTIDO_TABLE . " p
              JOIN equipos el ON p.id_local = el.id_equipo
              JOIN equipos ev ON p.id_visitante = ev.id_equipo
              WHERE p.jornada = ?
              ORDER BY p.id_partido ASC";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $jornada);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = array();
        while ($partidoDB = mysqli_fetch_assoc($result)) {
            array_push($partidos, $partidoDB);
        }
        return $partidos;
    }

    /**
     * Obtiene una lista de los números de jornada únicos que ya tienen partidos registrados.
     *
     * @return array Un array con los números de las jornadas existentes.
     */
    public function getJornadas()
    {
        $query = "SELECT DISTINCT jornada FROM " . self::PARTIDO_TABLE . " ORDER BY jornada ASC";
        $result = mysqli_query($this->conn, $query);
        $jornadas = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($jornadas, $row['jornada']);
        }
        return $jornadas;
    }

    /**
     * Comprueba si ya existe un partido entre dos equipos, sin importar quién es local o visitante.
     *
     * @param int $id_local El ID del equipo que juega como local.
     * @param int $id_visitante El ID del equipo que juega como visitante.
     * @return bool Devuelve true si el partido ya existe, false en caso contrario.
     */
    public function checkPartidoExists($id_local, $id_visitante)
    {
        $query = "SELECT COUNT(*) as count FROM " . self::PARTIDO_TABLE .
            " WHERE (id_local = ? AND id_visitante = ?) OR (id_local = ? AND id_visitante = ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiii', $id_local, $id_visitante, $id_visitante, $id_local);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count = mysqli_fetch_assoc($result)['count'];
        return $count > 0;
    }
}