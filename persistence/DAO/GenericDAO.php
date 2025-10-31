<?php

/**
 * @author ivanc
 * 
 * Clase abstracta para los DAO (Data Access Object).
 * 
 * Esta clase proporciona la conexión a la base de datos y define la estructura 
 * que deben seguir los DAO concretos que hereden de ella.
 */

require __DIR__ . "/../conf/PersistentManager.php";

abstract class GenericDAO
{

    /**
     * @var mysqli Conexión a la base de datos.
     */
    protected $conn = null;

    /**
     * Constructor de la clase.
     * 
     * Se encarga de obtener la instancia del PersistentManager y establecer la conexión a la base de datos.
     */
    public function __construct()
    {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }

    /* Métodos abstracto genericos para las demas clases que extienden de esta. */
    abstract protected function selectAll();
    abstract protected function selectById($id);
    abstract protected function insert($dto);
}
