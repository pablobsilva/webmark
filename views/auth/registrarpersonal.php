<?php require_once '/var/www/WebMarketTest/views/layouts/headerempresa.php'; ?>
<div class="container-fluid">
      <form method="POST" action="<?php echo url ('auth/registrarpersonal')?>" class="row mt-5">
        <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
          <div class="card">
            <div class="card-header bg-danger text-white">
              <span>Registrar Personal</span>
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
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-success" name="registrar-btn">Registrar Personal</button>
            </div>
          </div>
        </div>
      </form>
    </div>

<?php require_once '/var/www/WebMarketTest/views/layouts/footerempresa.php'; ?>