<?php
session_start();
require_once 'Conexion.php';

if (!isset($_SESSION['usuario']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'];

$conexion = new Conexion();
$conn = $conexion->getConnection();

foreach ($carrito as $id => $item) {
    $cantidad = $item['cantidad'];

    $stmt = $conn->prepare("INSERT INTO compras (usuario, producto_id, cantidad) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error en prepare(): " . $conn->error);
    }

    $stmt->bind_param("sii", $usuario, $id, $cantidad);
    if (!$stmt->execute()) {
        die("Error al ejecutar: " . $stmt->error);
    }

    $stmt->close();
}

// Vaciar el carrito tras compra
unset($_SESSION['carrito']);

header("Location: catalogo.php?mensaje=compra_realizada");
exit;
?>
