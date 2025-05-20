<?php
require_once "Conexion.php";

// Establece las cabeceras para que el navegador descargue el XML
header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=catalogo.xml");

// Crear instancia de conexión
$db = new Conexion();

// Llamar al método que obtiene todos los productos (debes tenerlo en tu clase)
$res = $db->obtenerProductos();

// Imprimir encabezado XML
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<catalogo>\n";

// Recorrer los productos y construir nodos XML
while ($p = $res->fetch_assoc()) {
    echo "  <producto>\n";
    echo "    <nombre>" . htmlspecialchars($p['nombre']) . "</nombre>\n";
    echo "    <referencia>" . htmlspecialchars($p['referencia']) . "</referencia>\n";
    echo "    <precio>" . $p['precio'] . "</precio>\n";
    echo "  </producto>\n";
}

echo "</catalogo>";
?>

