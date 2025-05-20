<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: Login.html");
    exit();
}

// Conexión a la base de datos
include 'db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Repuestos Aeronáuticos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f6fa;
            padding: 20px;
        }
        .header {
            background-color: #1a237e;
            color: white;
            padding: 15px;
            border-radius: 6px;
        }
        .logout {
            float: right;
            background: #c62828;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        .productos {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            margin-top: 20px;
        }
        .card {
            background-color: white;
            padding: 15px;
            width: 280px;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
        }
        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
        }
        .btn-comprar {
            background-color: #1565c0;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
        .mensaje {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Tienda de Repuestos Aeronáuticos</h2>
        <span>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></span>
        <a href="logout.php" class="logout">Cerrar sesión</a>
    </div>

    <div class="productos">
        <?php
        $resultado = $conn->query("SELECT * FROM productos");

        while ($producto = $resultado->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<img src='{$producto['imagen']}' alt='Repuesto'>";
            echo "<h3>" . htmlspecialchars($producto['nombre']) . "</h3>";
            echo "<p>" . htmlspecialchars($producto['descripcion']) . "</p>";
            echo "<p><strong>Precio: $" . number_format($producto['precio'], 2) . "</strong></p>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='producto_id' value='{$producto['id']}'>";
            echo "<button class='btn-comprar' name='comprar'>Comprar</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>

    <?php
    if (isset($_POST['comprar']) && isset($_POST['producto_id'])) {
        $producto_id = intval($_POST['producto_id']);
        $stmt = $conn->prepare("SELECT nombre FROM productos WHERE id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($p = $res->fetch_assoc()) {
            echo "<p class='mensaje'> Has comprado el repuesto: <strong>" . htmlspecialchars($p['nombre']) . "</strong></p>";
        }
    }
    ?>
</body>
</html>