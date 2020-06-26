<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Agregar Productos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre"
                                        aria-describedby="emailHelp">
                                    <small id="emailHelp" class="form-text text-muted"> por si quieres mostrar una
                                        ayuda</small>
                                </div>
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="text" class="form-control" id="precio">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Codigo de Barra</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1">
                                </div>

                                <div class="form-group">
                                    <label for="categorias-cbx">Categoria:</label>
                                    <select class="form-control" id="categorias-cbx" name="categoria">
                                        <?php foreach($this->categorias as $categoria):?>
                                            <option value="<?php echo $categoria->idCategoria;?>"><?php echo $categoria->Nombre;?></option>
                                        <?php endforeach; ?>    
                                    </select> 
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Empresa</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Cantidad</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal -->

            </div>