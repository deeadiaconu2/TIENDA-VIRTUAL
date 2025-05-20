<?php
session_start(); // Iniciar sesión para acceder al carrito y usuario
require_once 'Conexion.php'; // Incluir la clase de conexión

// Si el usuario no está logueado, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}

// Verifica si se ha pasado un ID de producto por GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir a entero para seguridad

    // Si no existe el carrito en sesión, lo inicializa como array
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Si el producto ya está en el carrito, incrementar la cantidad
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += 1;
    } else {
        // Si no está, buscarlo en la base de datos y añadirlo
        $conexion = new Conexion();
        $conn = $conexion->getConnection();

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

// Redirige al carrito después de agregar el producto
header("Location: carrito.php");
exit;

