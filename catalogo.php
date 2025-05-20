<?php
session_start();
require_once 'Conexion.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}

// Establecer conexión con la base de datos
$conexion = new Conexion();
$conn = $conexion->getConnection();

$busqueda = '';

// Si se usa el buscador, filtra por nombre o referencia
if (isset($_GET['buscar'])) {
    $busqueda = trim($_GET['buscar']);
    $like = "%$busqueda%";
    $stmt = $conn->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR referencia LIKE ?");
    $stmt->bind_param("ss", $like, $like);
} else {
    // Si no hay búsqueda, mostrar todos los productos
    $stmt = $conn->prepare("SELECT * FROM productos");
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo de Repuestos</title>
  <style>
    /* Estilos generales del cuerpo */
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
    }

    /* Contenedor principal centrado */
    .contenedor {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px;
    }

    /* Título del catálogo */
    h1 {
      text-align: center;
      color: #003366;
      font-size: 2rem;
      margin-bottom: 30px;
    }

    /* Buscador centrado */
    .buscador {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
    }

    .buscador input[type="text"] {
      padding: 10px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 8px 0 0 8px;
      outline: none;
    }

    .buscador button {
      padding: 10px 20px;
      border: none;
      background-color: #003366;
      color: white;
      border-radius: 0 8px 8px 0;
      cursor: pointer;
      font-weight: bold;
    }

    /* Grid para organizar los productos */
    .catalogo {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    /* Estilo individual de cada producto */
    .producto {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .producto h2 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: #222;
    }

    .producto p {
      margin: 5px 0;
      font-size: 0.95rem;
    }

    .precio {
      color: green;
      font-weight: bold;
      font-size: 1.1rem;
      margin-top: 10px;
    }

    .producto button {
      margin-top: 15px;
      padding: 10px;
      background-color: #003366;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    .producto button:hover {
      background-color: #0055aa;
    }
  </style>
</head>
<body>

<div class="contenedor">
  <h1>Catálogo de Repuestos</h1>

  <!-- Formulario de búsqueda -->
  <div class="buscador">
    <form method="GET">
      <input type="text" name="buscar" placeholder="Buscar por nombre o referencia" value="<?= htmlspecialchars($busqueda) ?>">
      <button type="submit">Buscar</button>
    </form>
  </div>

  <!-- Mostrar productos -->
  <div class="catalogo">
    <?php while ($producto = $resultado->fetch_assoc()): ?>
      <div class="producto">
        <!-- Mostrar nombre del producto -->
        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
        <p><strong>Ref:</strong> <?= $producto['referencia'] ?></p>
        <p class="precio">$<?= number_format($producto['precio'], 2) ?></p>

        <!-- Botón para agregar al carrito -->
        <form action="agregar_carrito.php" method="GET">
          <input type="hidden" name="id" value="<?= $producto['id'] ?>">
          <button type="submit">Agregar al carrito</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>




