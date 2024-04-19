<?php

header('Content-Type: application/json');

require("conexion.php");

$conexion = retornarConexion();

switch ($_GET['accion']) {

  case 'agregar':
    // Escapar correctamente las entradas del usuario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombrenuevo']);
    $clave = mysqli_real_escape_string($conexion, $_POST['clave1']);
    
    // Consulta preparada para agregar un nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, clave) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $clave);
    $respuesta = $stmt->execute();
    
    // Enviar respuesta JSON
    echo json_encode(array("success" => $respuesta));
    break;
    
  case 'existe':
    // Escapar correctamente las entradas del usuario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombrenuevo']);
    
    // Consulta preparada para verificar si el usuario existe
    $stmt = $conexion->prepare("SELECT nombre FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->store_result();
    
    // Determinar si el usuario existe o no
    $cantidad = $stmt->num_rows;
    if ($cantidad == 1)
      echo '{"resultado":"repetido"}';
    else
      echo '{"resultado":"norepetido"}';
    break;
}

?>
