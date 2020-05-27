<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>666</title>
  </head>
  <body>
    <div class="container-fluid">
      <form method="POST" action="" class="row mt-5">
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
              <span>HOLITA</span>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" required name="usuario" value="">
              </div>
              <div class="form-group">
                <label for="password">Clave</label>
                <input type="password" class="form-control" required name="password" value="">
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary" name="ingresar-btn">Iniciar Sesión</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
