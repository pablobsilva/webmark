<div class="modal fade modificarModal" id="modificarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modificar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombreModificar" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"> por si quieres mostrar una
                            ayuda</small>
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="text" class="form-control" id="precioModificar">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Codigo de Barra</label>
                        <input type="text" class="form-control" id="codigoBarraModificar">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Categoria</label>
                        <select type="text" class="form-control" id="categoriaModificar"></select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Empresa</label>
                        <input type="text" class="form-control" id="empresaModificar">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Cantidad</label>
                        <input type="text" class="form-control" id="cantidadModificar">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>