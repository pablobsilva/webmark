<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Inicie Sesion!</title>
</head>

<body class="container-fluid">

    <main class="row">

        <article class="col-sm-12 col-md-8 col-lg-8 vh-100">
            <div class="d-flex justify-content-center vh-100 align-items-center">
                
                <div style="width: 60%; height: 80%;" class="d-flex align-items-center">
                    
                    <div class="card text-black mb-3">
                        <div class="card-body">
                            <h1 class="card-title text-center mb-5">Ingrese sus datos, y sea bienvenido a nuestra comunidad!</h1>
                            
                          <!--  <form method="POST" action="" id="formcodigo">
                            <div>
                                <h1> <label for="basic-url">Codigo de barras:</label> </h1>
                                    <input type="text" id="codigodebarrastxt" name="codigodebarra" value="" />
                                    <button type="submit" id="btn-producto"> TEST </button>
                                </div>                         
                            </form> --> 

                            <form method="POST" action="<?php echo url ('auth/registrar')?>" class="row mt-5">

                                <div>
                                    <h1> <label for="basic-url">Ingrese su nombre:</label> </h1>
                                    <div class="input-group input-group-lg mb-3">
                                        <input type="text" class="form-control" name="nombre"
                                        aria-describedby="basic-addon3">
                                    </div>
                                <div>
                                    <h1> <label for="basic-url">Ingrese su rut:</label> </h1>
                                    <div class="input-group input-group-lg mb-3">
                                        <input type="text" class="form-control" name="rut"
                                        aria-describedby="basic-addon3">
                                    </div>
                                </div>
                                
                                <div>
                                    <h1> <label for="basic-url">ingrese su contrasena:</label> </h1>
                                    <div class="input-group input-group-lg mb-3">
                                        <input type="text" class="form-control" id="basic-url" name="password"
                                        aria-describedby="basic-addon3">
                                    </div>
                                </div>                            
                                
                                <button type="submit" class="btn btn-light btn-lg btn-block">Registrarse</button>
                                <button type="button" class="btn btn-secondary btn-lg btn-block" style="background-color: orangered !important;">
                                    <a href="<?php echo url('auth/login') ?>">Iniciar Sesion</a>
                                </button>

                            </form>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </article>
        
        <article class="col-sm-12 col-md-4 col-lg-4 vh-100 d-flex justify-content-center">
            <div class="row row-cols-sm-1 row-cols-md-1 vh-100" style="width: 80%;">
                <div style="width: 100%; height: 40%; background-color: orangered;">
                    <img src="" alt="AQUI DEBERIA IR UNA IMAGEN">
                </div>
                <div style="width: 100%; height: 20%; display: flex; justify-content: center; align-items: center; background-color: #f4f4f6 !important;">
                    <h1>TODO COMIENZA AHORA!</h1>
                </div>
                <div style="width: 100%; height: 40%; background-color: orangered;">
                    <img src="" alt="AQUI DEBERIA IR UNA IMAGEN">
                </div>
            </div>
        </article>

    </main>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="/js/test.js"></script>  
</body>

</html>