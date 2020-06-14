
<form method="POST" action="<?php echo url ('productos/agregar')?>">

<div class="form-group">
    <label for="nombre">Nombre producto</label>
    <input type="text" class="form-control" required name="nombre" value="">
</div>
<div class="form-group">
    <label for="precio">Precio</label>
    <input type="number" class="form-control" required name="precio" value="">
</div>
<div class="form-group">
    <label for="codigodebarra">Codigo de Barra</label>
    <input type="text" class="form-control" required name="codigodebarra" value="">
</div>

<div class="form-group">
    <label for="categorias-cbx">Categoria:</label>
    <select class="form-control" id="categorias-cbx" name="categoria">
        <?php foreach($this->categorias as $categoria):?>
            <option value="<?php echo $categoria->idCategoria;?>"><?php echo $categoria->Nombre;?></option>
        <?php endforeach; ?>    
    </select> 
</div>
<button type="submit" class="btn btn-success" name="agregarproducto-btn">Agregar Producto</button>
</form>