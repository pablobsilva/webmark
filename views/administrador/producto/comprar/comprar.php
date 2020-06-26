<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Administrador</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link href="/css/administrador/left-sidebar.css" rel="stylesheet">

</head>

<body>

    <!-- NAVBAR -->
    <?php require '/var/www/WebMarketTest/views/administrador/menus/navbar/navbar.php' ?>
    <!-- NAVBAR -->

    <div class="container-fluid">
        <div class="row">

            <!-- LEFT SIDEBAR -->
            <?php require '/var/www/WebMarketTest/views/administrador/menus/left-sidebar/left-sidebar.php' ?>
            <!-- LEFT SIDEBAR -->


            <!-- CONTENT PAGE -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                    <h1 class="h2">Comprar Productos</h1>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Pistolear Producto</span>
                            </div>
                            <input type="text" class="form-control" placeholder="codigo de barra"
                                aria-label="codigo de barra" aria-describedby="basic-addon1" id="codigoBarraShooted">
                            <button class="btn btn-primary" id="codigoBarraShoot" >Agregar</button>
                        </div>
                    </div>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                data-target="#agregarModal">
                                Agregar Producto
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">ALGO</button>
                        </div>
                    </div>

                </div>

                <form class="mt-5">
                    
                    <h1>DATOS DE FACTURA</h1>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Fecha</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Registrar</button>
                <div class="table-responsive mt-5">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" id="thID">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Codigo de Barra</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col"> <span data-feather="edit"> </span> </th>
                                <th scope="col"> <span data-feather="trash-2"></span> </th>
                            </tr>
                        </thead>
                        <tbody id="table">
                        
                        </tbody>
                    </table>
                </form>
                </div>

            </main>
            <!-- CONTENT PAGE -->

            <!-- Modal Agregar-->
            <?php require '/var/www/WebMarketTest/views/administrador/producto/modales/agregar-producto.php' ?>
            <!-- Modal Agregar-->

            <!-- Modal Modificar-->
            <?php require '/var/www/WebMarketTest/views/administrador/producto/modales/modificar-producto.php' ?>
            <!-- Modal Modificar-->

        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

    <script src="/js/administrador/producto/productos.js"></script>
    <script src="/js/administrador/producto/comprar.js"></script>

</body>

</html>