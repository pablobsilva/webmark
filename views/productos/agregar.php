<div class="form-group">
    <label for="categorias-cbx">Categoria:</label>
    <select class="form-control" id="categorias-cbx" name="categorias">
        <?php foreach($this->categorias as $categoria):?>
            <option value="<?php echo $categoria->Nombre;?>"><?php echo $categoria->Nombre;?></option>
        <?php endforeach; ?>    
    </select> 
</div>
