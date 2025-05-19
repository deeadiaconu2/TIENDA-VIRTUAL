<?php
session_start();
require_once 'Conexion.php';

// Proteger acceso solo a usuarios logueados
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}

// Conexión y búsqueda
$conexion = new Conexion();
$conn = $conexion->getConnection(); //Correcto


$busqueda = '';
if (isset($_GET['buscar'])) {
    $busqueda = trim($_GET['buscar']);
    $stmt = $conn->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR referencia LIKE ?");
    $like = "%$busqueda%";
    $stmt->bind_param("ss", $like, $like);
} else {
    $stmt = $conn->prepare("SELECT * FROM productos");
}

$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo de Productos</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f0f2f5;
    }
    h1 {
      text-align: center;
      color: #003366;
    }
    .buscador {
      max-width: 500px;
      margin: 0 auto 30px;
      text-align: center;
    }
    input[type="text"] {
      padding: 10px;
      width: 70%;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      padding: 10px 15px;
      background-color: #003366;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .catalogo {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }
    .producto {
      background-color: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .producto h2 {
      font-size: 1.1rem;
    }
    .precio {
      font-weight: bold;
      color: green;
    }
  </style>
</head>
<body>
  <h1>Catálogo de Repuestos</h1>

  <div class="buscador">
    <form method="GET">
      <input type="text" name="buscar" placeholder="Buscar por nombre o referencia" value="<?= htmlspecialchars($busqueda) ?>">
      <button type="submit">Buscar</button>
    </form>
  </div>

  <div class="catalogo">
    <?php while ($producto = $resultado->fetch_assoc()): ?>
      <div class="producto">
        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
        <p><strong>Ref:</strong> <?= $producto['referencia'] ?></p>
        <p class="precio">$<?= number_format($producto['precio'], 2) ?></p>
        <form action="agregar_carrito.php" method="GET">
          <input type="hidden" name="id" value="<?= $producto['id'] ?>">
          <button type="submit">Agregar al carrito</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>


