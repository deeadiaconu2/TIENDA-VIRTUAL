<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario con validación
    $usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    // Conexión segura a la base de datos
    $conn = new mysqli("localhost", "root", "", "tienda_virtual");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Buscar al usuario en la base de datos
    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    // Verifica si existe el usuario
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        // Verificar la contraseña cifrada
        if (password_verify($password, $hash)) {
            echo "Inicio de sesión exitoso";
            // Aquí puedes iniciar sesión con session_start() y redirigir
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }

    $stmt->close();
    $conn->close();
}
?>

