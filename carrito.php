<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}

$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f4f4f4;
    }
    h1 {
      text-align: center;
      color: #003366;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
      text-align: center;
    }
    .total {
      font-weight: bold;
      font-size: 1.2rem;
      text-align: right;
      margin-top: 20px;
    }
    .btn {
      display: block;
      margin: 30px auto;
      padding: 10px 20px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h1>Carrito de Compras</h1>

<?php if (empty($carrito)): ?>
  <p style="text-align: center;">El carrito está vacío.</p>
<?php else: ?>
  <table>
    <tr>
      <th>Producto</th>
      <th>Referencia</th>
      <th>Cantidad</th>
      <th>Precio</th>
      <th>Subtotal</th>
    </tr>
    <?php foreach ($carrito as $id => $item): 
      $subtotal = $item['precio'] * $item['cantidad'];
      $total += $subtotal;
    ?>
      <tr>
        <td><?= htmlspecialchars($item['nombre']) ?></td>
        <td><?= htmlspecialchars($item['referencia']) ?></td>
        <td><?= $item['cantidad'] ?></td>
        <td>$<?= number_format($item['precio'], 2) ?></td>
        <td>$<?= number_format($subtotal, 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <div class="total">Total: $<?= number_format($total, 2) ?></div>

  <form action="comprar.php" method="POST">
    <button class="btn" type="submit">Finalizar Compra</button>
  </form>
<?php endif; ?>

</body>
</html>
