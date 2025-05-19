<?php
session_start();
require_once 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger y limpiar datos
    $usuario     = trim($_POST['usuario']);
    $password    = trim($_POST['password']);
    $nombre      = trim($_POST['nombre']);
    $apellidos   = trim($_POST['apellidos']);
    $correo      = trim($_POST['correo']);
    $fecha       = $_POST['fecha_nacimiento'];
    $genero      = $_POST['genero'];

    // Validaciones
    if (empty($usuario) || empty($password) || empty($nombre) || empty($correo)) {
        die("Por favor completa todos los campos obligatorios.");
    }

    if (strlen($password) < 6) {
        die("La contraseña debe tener al menos 6 caracteres.");
    }

    $conexion = new Conexion();
    $conn = $conexion->conn;

    // Comprobar si el usuario ya existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $check->bind_param("s", $usuario);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("El nombre de usuario ya está registrado.");
    }
    $check->close();

    // Encriptar contraseña
    $hash = password_hash($password, PASSWORD_BCRYPT);

    // Insertar en usuarios
    $insertUser = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
    $insertUser->bind_param("ss", $usuario, $hash);
    if (!$insertUser->execute()) {
        die("Error al registrar usuario.");
    }
    $insertUser->close();

    // Insertar en clientes
    $insertCliente = $conn->prepare("INSERT INTO clientes (usuario, nombre, apellidos, correo, fecha_nacimiento, genero) VALUES (?, ?, ?, ?, ?, ?)");
    $insertCliente->bind_param("ssssss", $usuario, $nombre, $apellidos, $correo, $fecha, $genero);
    if (!$insertCliente->execute()) {
        die("Error al guardar datos del cliente.");
    }
    $insertCliente->close();

    // Redirigir con mensaje de éxito
    header("Location: login.html?registro=exitoso");
    exit;
}
?>

