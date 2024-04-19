<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location:login.html");
  exit(0);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💰 Sistema de Facturación</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style>
        a {
            color: black; /* Cambia el color del texto a negro */
            text-decoration: none; /* Elimina el subrayado */
        }
        .formulario {
            background-color: #f9f9f9; /* Color de fondo */
            padding: 20px; /* Espaciado interno */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Sombra */
        }
       
        .usuario{
            margin-right: 4px;
            font-size: 20px;
            position: inline;
            color: black;
            padding: auto;
        }

        .icono{

            size: 14px;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Facturación</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php"><i class="fas fa-home"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="facturacion.php"><i class="fas fa-file-invoice"></i> Nueva Factura</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-cogs"></i> Configuración</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="categorias/administracion.html"><i class="fas fa-tags"></i> Mantenimiento de categorías</a>
                        <a class="dropdown-item" href="productos/administracion.html"><i class="fas fa-box-open"></i> Mantenimiento de productos</a>
                        <a class="dropdown-item" href="clientes/administracion.html"><i class="fas fa-users"></i> Mantenimiento de clientes</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="false">
                        <i class="fas fa-chart-bar"></i> Panel-Administrativo
                    </a>
                </li>
            </ul>
            <section class="content-header">
                <h2>
                    <small class="usuario" style="m-3"><?php echo $_SESSION['usuario']; ?></strong></small>
                    <small class="icono" style="float:right m-3"><a href="logout.php"><i class="fas fa-sign-out-alt"></i></a></small>
                </h2>

            </section>
        </div>
    </div>
</nav>
