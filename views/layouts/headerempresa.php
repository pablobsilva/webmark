<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Market </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('css/style.css'); ?>">
</head>
<body>
<div id="AgregarProductoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Agregar un producto a su empresa</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="<?php echo url('gestionar');?>">GESTIONAR EMPRESA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link" href=<?php echo url('/ventas/vender');?>>Realizar venta<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href=<?php echo url('/solicitudes/cuentas');?>>Cuentas</a>
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Productos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href=<?php echo url('/productos/productosver');?>>Ver Productos</a>
          <a class="dropdown-item" data-toggle="modal" data-target="#AgregarProductoModal" href="/productos/agregar">Agregar Producto</a>
          <!-- <div class="dropdown-divider"></div> -->
          <a class="dropdown-item" href="#">Editar Producto</a>
        </div>
      </li>
        </div>
      </div>
      <div>
        <p class="text-white">Bienvenido <?php echo $_SESSION['auth']['nombre']?> </p>
        <a href=<?php echo url('auth/logout');?> class="text-white">Cerrar sesión</a>
      </div>
    </nav>
</header>
