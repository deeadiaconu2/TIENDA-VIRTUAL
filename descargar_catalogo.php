<?php
require_once "Conexion.php";
header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=catalogo.xml");

$db = new Conexion();
$res = $db->obtenerProductos();

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<catalogo>\n";

while ($p = $res->fetch_assoc()) {
    echo "  <producto>\n";
    echo "    <nombre>" . htmlspecialchars($p['nombre']) . "</nombre>\n";
    echo "    <referencia>" . htmlspecialchars($p['referencia']) . "</referencia>\n";
    echo "    <precio>" . $p['precio'] . "</precio>\n";
    echo "  </producto>\n";
}

echo "</catalogo>";
