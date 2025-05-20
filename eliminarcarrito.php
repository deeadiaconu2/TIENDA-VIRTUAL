<?php
session_start(); // Iniciar la sesión para acceder al carrito

// Verifica si se recibió un ID por la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegura que el ID sea un número entero

    // Si el producto existe en el carrito, lo elimina
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
    }
}

// Redirige de nuevo al carrito después de eliminar
header("Location: carrito.php");
exit;

