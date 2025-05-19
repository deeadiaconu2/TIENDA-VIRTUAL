<?php
session_start();
require_once 'Conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += 1;
    } else {
        $conexion = new Conexion();
        $conn = $conexion->getConnection(); //aquí usamos getConnection()

        $res = $conn->query("SELECT * FROM productos WHERE id = $id");

        if ($res && $res->num_rows > 0) {
            $producto = $res->fetch_assoc();
            $_SESSION['carrito'][$id] = [
                'nombre' => $producto['nombre'],
                'referencia' => $producto['referencia'],
                'precio' => $producto['precio'],
                'cantidad' => 1
            ];
        }
    }
}

header("Location: carrito.php");
exit;

