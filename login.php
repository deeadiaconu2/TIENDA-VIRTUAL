<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar si las claves existen antes de usarlas
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "nombre_de_tu_base_de_datos");

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Inicio de sesión exitoso";
    } else {
        echo "Usuario o contraseña incorrectos";
    }

    $stmt->close();
    $conn->close();
}
?>
