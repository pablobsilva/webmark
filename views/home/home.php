<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/home/home.css">

    <link rel="stylesheet" href="/css/home/carousel/carousel.css">

    <title>Bienvenidos!</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Quienes Somos?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contactanos!</a>
                </li>
            </ul>
            <button class="btn btn-warning naranja">
                <a href="<?php echo url('auth/login') ?>">Iniciar Sesion</a> 
            </button>
        </div>
    </nav>

    <main class="container-fluid">

        <article class="row article-nosotros">

            <!-- Mensaje de bienvenida -->
            <div class="col">

                <div class="row row-cols-sm-1 row-cols-md-1 bienvenida">

                    <div class="col title-bienvenida">
                        <div class="row row-cols-sm-1 row-cols-md-1">
                            <div class="col">
                                <span>La administracion en</span>
                            </div>
                            <div class="col">
                                <span>TU MANO</span>
                                <div class="separate-line">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col body-bienvenida">
                        <div>
                            <div>
                                <span>si quieres conocer mas de nosotros <button
                                        class="btn btn-warning naranja">contactanos</button> </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- CARRUSEL -->
            <div class="col">

                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/assets/home/carousel/nose.jpg" class="d-block w-100 img-fluid"
                                alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/home/carousel/nose.jpg" class="d-block w-100 img-fluid"
                                alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/home/carousel/nose.jpg" class="d-block w-100 img-fluid"
                                alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
        </article>

        <article class="row info-empresa">

            <div class="col-sm-12 col-md-12 col-lg-12">
                <span>Informacion de la empresa</span>
            </div>


            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                <div class="row justify-content-center">

                    <div class="col-sm-12 col-md-3 col-lg-3 justify-content-center">
                        <div class="card text-white bg-primary mb-3" style="max-width: 100%;">
                            <div class="card-header">Header</div>
                            <div class="card-body">
                                <h5 class="card-title">Primary card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3 justify-content-center">
                        <div class="card text-white bg-primary mb-3" style="max-width: 100%;">
                            <div class="card-header">Header</div>
                            <div class="card-body">
                                <h5 class="card-title">Primary card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3 justify-content-center">
                        <div class="card text-white bg-primary mb-3" style="max-width: 100%;">
                            <div class="card-header">Header</div>
                            <div class="card-body">
                                <h5 class="card-title">Primary card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </article>

    </main>

    <footer class="text-center mt-5" style="background-color: #10124b;">
        <span style="color: white;">LOS DERECHOS RESERVADOS</span>
    </footer>


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
</body>

</html>