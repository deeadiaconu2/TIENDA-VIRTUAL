<?php
require_once 'Conexion.php';

$conn = (new Conexion())->getConnection();
echo "Conexión exitosa";
?>
