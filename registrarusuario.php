<?php
session_start();
require_once 'Conexion.php';

// Verifica si el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Recoger y limpiar los datos del formulario
    $usuario     = trim($_POST['usuario']);
    $password    = trim($_POST['password']);
    $nombre      = trim($_POST['nombre']);
    $apellidos   = trim($_POST['apellidos']);
    $correo      = trim($_POST['correo']);
    $fecha       = $_POST['fecha_nacimiento'];
    $genero      = $_POST['genero'];

    // Validación de campos obligatorios
    if (empty($usuario) || empty($password) || empty($nombre) || empty($correo)) {
        die("Por favor completa todos los campos obligatorios.");
    }

    // Verificación de longitud mínima de la contraseña
    if (strlen($password) < 6) {
        die("La contraseña debe tener al menos 6 caracteres.");
    }

    // Crear conexión con la base de datos
    $conexion = new Conexion();
    $conn = $conexion->getConnection();

    // Comprobar si el usuario ya existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $check->bind_param("s", $usuario);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("El nombre de usuario ya está registrado.");
    }
    $check->close();

    // Cifrar la contraseña de forma segura
    $hash = password_hash($password, PASSWORD_BCRYPT);

    // Insertar datos en la tabla 'usuarios'
    $insertUser = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
    $insertUser->bind_param("ss", $usuario, $hash);
    if (!$insertUser->execute()) {
        die("Error al registrar usuario.");
    }
    $insertUser->close();

    // Insertar información adicional en la tabla 'clientes'
    $insertCliente = $conn->prepare("INSERT INTO clientes (usuario, nombre, apellidos, correo, fecha_nacimiento, genero) VALUES (?, ?, ?, ?, ?, ?)");
    $insertCliente->bind_param("ssssss", $usuario, $nombre, $apellidos, $correo, $fecha, $genero);
    if (!$insertCliente->execute()) {
        die("Error al guardar datos del cliente.");
    }
    $insertCliente->close();

    // Redirigir al login con mensaje de éxito
    header("Location: login.html?registro=exitoso");
    exit;
}
?>


