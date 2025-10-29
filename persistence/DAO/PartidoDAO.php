<?php

require_once 'GenericDAO.php';

class PartidoDAO extends GenericDAO
{

    const PARTIDO_TABLE = 'partidos';

    public function selectAll()
    {
        $query = "SELECT p.*, el.nombre as nombre_local, ev.nombre as nombre_visitante 
              FROM " . self::PARTIDO_TABLE . " p
              JOIN equipos el ON p.id_local = el.id_equipo
              JOIN equipos ev ON p.id_visitante = ev.id_equipo
              ORDER BY p.jornada ASC, p.id_partido ASC";

        $result = mysqli_query($this->conn, $query);
        $partidos = array();
        while ($partidoDB = mysqli_fetch_assoc($result)) {
            array_push($partidos, $partidoDB);
        }
        return $partidos;
    }

    // Devuelve todos los partidos de un equipo (local o visitante)
    public function selectByEquipoId($id_equipo)
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

    # Inserta un nuevo partido en la tabla partidos devolviendo true si se ha insertado bien
    public function insert($dto)
    {
        // $dto es un array ['id_local', 'id_visitante', 'resultado', 'jornada', 'estadio_partido']
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

    //  Devuelve todos los partidos de una jornada
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

    // Devuelve una lista de jornadas únicas que ya tienen partidos
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

    // Comprueba si esos dos equipos ya han jugado
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
