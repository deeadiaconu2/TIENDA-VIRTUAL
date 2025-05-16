<?php
session_start();
include 'Conexion.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$dConnect = new  Conexion;

$sql="SELECT contrasena FROM usuarios WHERE usuario";
$result = $dConnect-> exec_query($sql);

if ($row = $result->fetch_assoc()) {
    if (password_verify($contrasena, $row['contrasena'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: tienda.php");
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
?>
