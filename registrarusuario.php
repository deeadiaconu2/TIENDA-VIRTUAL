<?php
include 'includes/conexion.php';

$usuario = $_POST['usuario'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$fecha = $_POST['fecha_nacimiento'];
$genero = $_POST['genero'];

$query1 = $conexion->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)");
$query1->bind_param("ss", $usuario, $contrasena);
$query1->execute();

$query2 = $conexion->prepare("INSERT INTO clientes (usuario, nombre, apellidos, correo, fecha_nacimiento, genero) VALUES (?, ?, ?, ?, ?, ?)");
$query2->bind_param("ssssss", $usuario, $nombre, $apellidos, $correo, $fecha, $genero);
$query2->execute();

header("Location: login.html");
?>
