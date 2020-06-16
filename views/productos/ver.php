<?php require_once '/var/www/WebMarketTest/views/layouts/headerempresa.php'?>

<h1> aki la merca </h1>

<div class="col-lg col-md col-sm">
    <table id="tabla-productos" class="table">
        <thead>
        <tr>
            <th></th>
            <th>Producto</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Precio</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($this->productos as $producto):?>
        <tr>
           <td><?php echo $producto->nombre;?></td>
           <td><?php echo $producto->categoria_idCategoria;?></td>
           <td><?php echo $producto->empresa;?></td>
           <td></td> 
        </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?php require_once '/var/www/WebMarketTest/views/layouts/footerempresa.php'; ?>