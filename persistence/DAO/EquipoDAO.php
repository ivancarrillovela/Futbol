<?php

require_once 'GenericDAO.php';

class EquipoDAO extends GenericDAO
{

    const EQUIPO_TABLE = 'equipos';

    public function selectAll()
    {
        $query = "SELECT * FROM " . self::EQUIPO_TABLE;
        $result = mysqli_query($this->conn, $query);
        $equipos = array();
        while ($equipoDB = mysqli_fetch_array($result)) {
            $equipo = array(
                'id_equipo' => $equipoDB["id_equipo"],
                'nombre' => $equipoDB["nombre"],
                'estadio' => $equipoDB["estadio"],
            );
            array_push($equipos, $equipo);
        }
        return $equipos;
    }

    public function insert($dto)
    {
        $query = "INSERT INTO " . self::EQUIPO_TABLE .
            " (nombre, estadio) VALUES(?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $dto['nombre'], $dto['estadio']);
        return $stmt->execute();
    }

}
