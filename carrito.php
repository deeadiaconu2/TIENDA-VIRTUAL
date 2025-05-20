<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}

// Obtener el carrito desde la sesión o inicializar como array vacío
$carrito = $_SESSION['carrito'] ?? [];
$total = 0; // Inicializar total de la compra
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <style>
    /* Estilo general */
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: #003366;
      margin-bottom: 30px;
    }

    /* Tabla del carrito */
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #003366;
      color: white;
      font-size: 1rem;
    }

    tr:last-child td {
      border-bottom: none;
    }

    /* Total de la compra */
    .total {
      text-align: right;
      font-weight: bold;
      font-size: 1.2rem;
      padding: 20px 0;
    }

    /* Botón de compra */
    .btn-finalizar {
      display: block;
      margin: 20px auto;
      padding: 12px 25px;
      font-size: 1rem;
      background-color: green;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    .btn-finalizar:hover {
      background-color: darkgreen;
    }

    /* Botón eliminar producto */
    .btn-eliminar {
      color: white;
      background-color: crimson;
      padding: 6px 10px;
      border: none;
      border-radius: 5px;
      font-size: 0.9rem;
      cursor: pointer;
    }

    .btn-eliminar:hover {
      background-color: darkred;
    }
  </style>
</head>
<body>

<h1>Carrito de Compras</h1>

<?php if (empty($carrito)): ?>
  <!-- Mostrar mensaje si el carrito está vacío -->
  <p style="text-align:center;">Tu carrito está vacío.</p>
<?php else: ?>
  <!-- Tabla de productos en el carrito -->
  <table>
    <tr>
      <th>Producto</th>
      <th>Referencia</th>
      <th>Cantidad</th>
      <th>Precio</th>
      <th>Subtotal</th>
      <th>Eliminar</th>
    </tr>

    <!-- Mostrar cada producto en el carrito -->
    <?php foreach ($carrito as $id => $item): 
      $subtotal = $item['precio'] * $item['cantidad'];
      $total += $subtotal;
    ?>
    <tr>
      <td><?= htmlspecialchars($item['nombre']) ?></td>
      <td><?= $item['referencia'] ?></td>
      <td><?= $item['cantidad'] ?></td>
      <td>$<?= number_format($item['precio'], 2) ?></td>
      <td>$<?= number_format($subtotal, 2) ?></td>
      <td>
        <!-- Botón para eliminar producto del carrito -->
        <a href="eliminar_carrito.php?id=<?= $id ?>" class="btn-eliminar">X</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>

  <!-- Mostrar total y botón de finalizar -->
  <p class="total">Total: $<?= number_format($total, 2) ?></p>

  <form action="comprar.php" method="POST">
    <button class="btn-finalizar" type="submit">Finalizar Compra</button>
  </form>
<?php endif; ?>

</body>
</html>
