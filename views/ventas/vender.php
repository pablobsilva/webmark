<?php require_once '/var/www/WebMarketTest/views/layouts/headerempresa.php'?>


<form method="POST" action="<?php echo url ('productos/agregar')?>">

<div class="col-lg col-md col-sm    ">
    <table id="tabla-productos" class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div class="card-footer">
        <span id="span-precio">Total: </span>
    </div>
    <input type="submit" value="Registrar Venta" class="btn btn-success">    

</form>
<?php require_once '/var/www/WebMarketTest/views/layouts/footerempresa.php'; ?>