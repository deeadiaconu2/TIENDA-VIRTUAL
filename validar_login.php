<?php
session_start();
require_once 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Verificar que los campos no estén vacíos
    if (empty($usuario) || empty($password)) {
        die("Por favor, completa todos los campos.");
    }

    // Obtener conexión usando el método getConnection()
    $conexion = new Conexion();
    $conn = $conexion->getConnection();

    // Consulta segura con prepared statement
    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE usuario = ?");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si el usuario existe
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hash)) {
            $_SESSION['usuario'] = $usuario;
            header("Location: catalogo.php"); // o tienda.php si así se llama tu catálogo
            exit;
        } else {
            die("Contraseña incorrecta.");
        }
    } else {
        die("Usuario no encontrado.");
    }

    $stmt->close();
    $conn->close();
} else {
    die("Acceso no permitido.");
}
?>

