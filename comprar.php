<?php
session_start();
require_once 'Conexion.php';

// Verifica que el usuario esté logueado y que el carrito no esté vacío
if (!isset($_SESSION['usuario']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'];

$conexion = new Conexion();
$conn = $conexion->getConnection();

// Registrar cada producto del carrito en la tabla de compras
foreach ($carrito as $id => $item) {
    $cantidad = $item['cantidad'];

    // Preparar consulta segura para insertar compra
    $stmt = $conn->prepare("INSERT INTO compras (usuario, producto_id, cantidad) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error en prepare(): " . $conn->error);
    }

    // Vincular parámetros y ejecutar
    $stmt->bind_param("sii", $usuario, $id, $cantidad);
    if (!$stmt->execute()) {
        die("Error al ejecutar: " . $stmt->error);
    }

    $stmt->close(); // Cierra la consulta
}

// Limpiar el carrito después de la compra
unset($_SESSION['carrito']);

// Redirigir al catálogo con mensaje de éxito
header("Location: catalogo.php?mensaje=compra_realizada");
exit;
?>

