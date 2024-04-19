<?php
header('Content-Type: application/json');
require("conexion.php");

$conexion = retornarConexion();

mysqli_query($conexion, "delete from facturas where codigo=".$_GET['codigofactura']);
mysqli_query($conexion, "delete from detallefactura where codigofactura=".$_GET['codigofactura']);
header('location:index.php');

?>
