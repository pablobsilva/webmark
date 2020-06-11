<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Crear cuenta</title>
  </head>
  <body>
    <div class="container-fluid">
      <form method="POST" action="<?php echo url ('auth/registrar')?>" class="row mt-5">
        <?php if(isset($error)){
          ?>
          <div class="alert alert-warning col-lg-12 col-md-12 col-sm-12 mx-auto">
            <span><?php echo $error; ?></span>
          </div>
          <?php
        } ?>
        <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
          <div class="card">
            <div class="card-header bg-danger text-white">
              <span>Registrar usuario</span>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="usuario">Rut</label>
                <input type="text" class="form-control" required name="rut" value="">
              </div>
              <div class="form-group">
                <label for="usuario">Nombre</label>
                <input type="text" class="form-control" required name="nombre" value="">
              </div>
              <div class="form-group">
                <label for="password">Clave</label>
                <input type="password" class="form-control" required name="password" value="">
              </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="tipo-usuario" id="radio-empresa" value="1" checked>
            <label class="form-check-label" for="radio-empresa">
                Empresa
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="tipo-usuario" id="radio-usuario" value="0">
            <label class="form-check-label" for="radio-usuario">
                Usuario Normal
            </label>
            </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-success" name="registrar-btn">Registrarse</button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <!-- Optional JavaScript -->

  </body>
</html>
