<?php
class Conexion {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "tienda_virtual";
    private $port = 3306;
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->database,
            $this->port
        );

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
