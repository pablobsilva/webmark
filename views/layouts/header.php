<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Market </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="<?php echo url('gestionar');?>">GESTIONAR EMPRESA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link" href=<?php echo url('solicitudes/venta');?>>Realizar venta<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href=<?php echo url('solicitudes/cuentas');?>>Cuentas</a>
          <a class="nav-item nav-link" href=<?php echo url('solicitudes/productos');?>>Productos</a>
        </div>
      </div>
      <div >
        <p class="text-white">Bienvenido <?php echo $_SESSION['auth']['nombre']?> </p>
        <a href=<?php echo url('auth/logout');?> class="text-white">Cerrar sesión</a>
      </div>
    </nav>
</header>
