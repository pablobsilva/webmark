<div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="productos/agregar">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" name="nombre">
                        <small id="emailHelp" class="form-text text-muted"> por si quieres mostrar una
                            ayuda</small>
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Codigo de Barra</label>
                        <input type="text" class="form-control" id="codigoBarra" name="codigodebarra">
                    </div>

                    <div class="form-group">
                        <label for="categorias-cbx">Categoria:</label>
                        <select class="form-control" name="categoria">
                            <?php foreach($this->categorias as $categoria):?>
                                <option value="<?php echo $categoria->idCategoria;?>"><?php echo $categoria->Nombre;?></option>
                            <?php endforeach; ?>    
                        </select> 
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Stock inicial</label>
                        <input type="number" class="form-control" id="cantidad" name="stock">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>