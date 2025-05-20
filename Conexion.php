<?php
class Conexion {
    // Datos de configuración de la base de datos
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "tienda_virtual";
    private $port = 3306;
    private $conn; // Objeto de conexión mysqli

    // Constructor: se ejecuta al crear una nueva instancia
    public function __construct() {
        // Crear la conexión con MySQL
        $this->conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->database,
            $this->port
        );

        // Verificar si hubo error de conexión
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        // Establecer conjunto de caracteres UTF-8
        $this->conn->set_charset("utf8");
    }

    // Método público para acceder a la conexión desde fuera
    public function getConnection() {
        return $this->conn;
    }
}
?>

