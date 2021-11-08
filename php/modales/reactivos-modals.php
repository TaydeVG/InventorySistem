<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nombre" class="col-form-label fw-bold">Nombre:</label>
                                <input type="text" class="form-control" id="recipient-nombre" placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-reactividad" class="col-form-label fw-bold">Reactividad:</label>
                                <input type="number" class="form-control" id="recipient-reactividad" min="0" max="4" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-inflamabilida" class="col-form-label fw-bold">inflamabilida:</label>
                                <input type="number" class="form-control" id="recipient-inflamabilida" min="0" max="4" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-riesgoSalud" class="col-form-label fw-bold">Riesgo a la
                                    salud:</label>
                                <input type="number" class="form-control" id="recipient-riesgoSalud" min="0" max="4" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-presentacion" class="col-form-label fw-bold">Presentación:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-presentacion">
                                    <option selected value="0">Selección</option>
                                    <option value="1">Frasco Vidrio</option>
                                    <option value="2">Frasco Plástico</option>
                                    <option value="3">Bidón Vidrio</option>
                                    <option value="4">Bidón Plástico</option>
                                    <option value="5">Galón Vidrio</option>
                                    <option value="6">Galón Plástico</option>
                                    <option value="7">Bolsa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nReactivo" class="col-form-label fw-bold">Cantidad de
                                    reactivo:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-nReactivo">
                                    <option selected value="0">Selección</option>
                                    <option value="1">Lleno</option>
                                    <option value="2">Medio</option>
                                    <option value="3">Poco</option>
                                    <option value="4">Vacio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-unidadMedida" class="col-form-label fw-bold">Unidad de
                                    medida:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-unidadMedida">
                                    <option selected value="0">Selección</option>
                                    <option value="1">Mililitro</option>
                                    <option value="2">Gramo</option>
                                    <option value="3">Litro</option>
                                    <option value="4">Kilogramo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-codigoAlmacenamiento" class="col-form-label fw-bold">Código de
                                    almacenamiento:</label>
                                <div class="input-group">
                                    <select class="form-select" aria-label="Default select example" id="recipient-codigoAlmacenamiento">
                                        <option selected value="0">Selección</option>
                                        <option value="1">Inflamable</option>
                                        <option value="2">Oxidante</option>
                                        <option value="3">Corrosivo</option>
                                        <option value="4">Tóxico</option>
                                        <option value="5">No preligroso</option>
                                    </select>
                                    <button class="btn btn-outline-light text-dark border" type="button" data-bs-toggle="popover" data-bs-placement="top" title="Ayuda" data-bs-content=" 
                                        <div class='row'>
                                            <div class='col-9'> >Inflamable </div>
                                            <div class='col-3'><div class='p-2 mb-3 bg-danger text-white'></div></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-9'> >Oxidante </div>
                                            <div class='col-3'><div class='p-2 mb-3 bg-warning text-white'></div></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-9'> >Corrosivo </div>
                                            <div class='col-3'><div class='p-2 mb-3 bg-light text-white'></div></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-9'> >Tóxico </div>
                                            <div class='col-3'><div class='p-2 mb-3 bg-primary text-white'></div></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-9'> >No preligroso </div>
                                            <div class='col-3'><div class='p-2 mb-3 bg-success text-white'></div></div>
                                        </div>
                                    ">?</button>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-caducidad" class="col-form-label fw-bold">Caducidad:</label>
                                <input type="date" class="form-control" id="recipient-caducidad">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nMueble" class="col-form-label fw-bold">No. de mueble:</label>
                                <input type="number" class="form-control" id="recipient-nMueble" placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nEstante" class="col-form-label fw-bold">No. de estante:</label>
                                <input type="number" class="form-control" id="recipient-nEstante" placeholder="Escribe Aquí">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-evenly">
                <button type="button" class="btn btn-outline-primary" id="btnModalSubmit">Guardar</button>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" id="btnModalCancel">Cancelar</button>
                <button type="button" class="btn btn-outline-secondary" id="btnClearModal" onclick="initFormModal(document.getElementById('modalId'))">Limpiar</button>
            </div>
        </div>
    </div>
</div>