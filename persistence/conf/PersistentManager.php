<?php

/**
 * @author ivanc
 * 
 * This class manages the connection to the database.
 * It follows the Singleton pattern to ensure that there is only one instance of the connection.
 */
class PersistentManager
{

    /**
     * Private instance of the connection.
     * @var PersistentManager
     */
    private static $instance = null;
    /**
     * Connection to the database.
     * @var mysqli
     */
    private static $connection = null;
    /**
     * Database connection parameters.
     */
    private $userBD = "";
    private $psswdBD = "";
    private $nameBD = "";
    private $hostBD = "";

    /**
     * Get the instance of the connection.
     * @return PersistentManager
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Private constructor of the class: we only want to build one instance.
     * It is in charge of establishing a connection with our GBBDD.
     */
    private function __construct()
    {
        $this->establishCredentials();

        PersistentManager::$connection = mysqli_connect($this->hostBD, $this->userBD, $this->psswdBD, $this->nameBD)
            or die("Could not connect to db: " . mysqli_connect_error());
        mysqli_query(PersistentManager::$connection, "SET NAMES 'utf8'");
    }

    /**
     * Establishes the credentials for the database connection from a JSON file.
     */
    private function establishCredentials()
    {
        $dir = __DIR__;
        // Reading configuration parameters from an external file
        if (file_exists($dir . '\credentials.json')) {
            $credentialsJSON = file_get_contents($dir . '\credentials.json');
            $credentials = json_decode($credentialsJSON, true);

            $this->userBD = $credentials["user"];
            $this->psswdBD = $credentials["password"];
            $this->nameBD = $credentials["name"];
            $this->hostBD = $credentials["host"];
        }
    }

    /**
     * Closes the connection.
     */
    public function close_connection()
    {
        mysqli_close($this->get_connection());
    }

    /**
     * Returns the instance of the connection.
     * @return mysqli
     */
    function get_connection()
    {
        return PersistentManager::$connection;
    }

    /**
     * Getters and Setters for the BD configuration parameters.
     */
    function get_hostBD()
    {
        return $this->hostBD;
    }

    function get_usuarioBD()
    {
        return $this->userBD;
    }

    function get_psswdBD()
    {
        return $this->psswdBD;
    }

    function get_nombreBD()
    {
        return $this->nameBD;
    }
}
