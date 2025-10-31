<?php

/**
 * @author ivanc
 * 
 * DAO para la tabla de equipos.
 * Hereda de GenericDAO y proporciona los métodos para realizar operaciones CRUD
 * (Crear, Leer, Actualizar, Borrar) y otras consultas específicas para la tabla de equipos.
 */

require_once 'GenericDAO.php';

class EquipoDAO extends GenericDAO
{

    /**
     * Constante que almacena el nombre de la tabla de equipos.
     */
    const EQUIPO_TABLE = 'equipos';

    /**
     * Selecciona todos los equipos de la base de datos.
     *
     * @return array Un array de arrays asociativos, donde cada array asociativo representa un equipo.
     */
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

    /**
     * Selecciona un equipo por su ID.
     *
     * @param int $id El ID del equipo a seleccionar.
     * @return array|null Un array asociativo con la información del equipo, o null si no se encuentra.
     */
    public function selectById($id)
    {
        $query = "SELECT nombre, estadio FROM " . self::EQUIPO_TABLE . " WHERE id_equipo=?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $nombre, $estadio);

        $equipo = null;
        if (mysqli_stmt_fetch($stmt)) {
            $equipo = array(
                'id_equipo' => $id,
                'nombre' => $nombre,
                'estadio' => $estadio
            );
        }

        return $equipo;
    }

    /**
     * Inserta un nuevo equipo en la base de datos.
     *
     * @param array $dto Un array asociativo con los datos del equipo a insertar (nombre y estadio).
     * @return bool Devuelve true si la inserción fue exitosa, false en caso contrario.
     */
    public function insert($dto)
    {
        // El array $dto debe contener: ['nombre', 'estadio']
        $query = "INSERT INTO " . self::EQUIPO_TABLE .
            " (nombre, estadio) VALUES(?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $dto['nombre'], $dto['estadio']);
        return $stmt->execute();
    }
}