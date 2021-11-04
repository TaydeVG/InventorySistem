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
                                <input type="text" class="form-control" id="recipient-nombre">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-reactividad" class="col-form-label fw-bold">Reactividad:</label>
                                <input type="text" class="form-control" id="recipient-reactividad">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-inflamabilida" class="col-form-label fw-bold">inflamabilida:</label>
                                <input type="text" class="form-control" id="recipient-inflamabilida">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-riesgoSalud" class="col-form-label fw-bold">Riesgo a la salud:</label>
                                <input type="text" class="form-control" id="recipient-riesgoSalud">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-presentacion" class="col-form-label fw-bold">Presentación:</label>
                                <input type="text" class="form-control" id="recipient-presentacion">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nReactivo" class="col-form-label fw-bold">Cantidad de reactivo:</label>
                                <input type="text" class="form-control" id="recipient-nReactivo">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-unidadMedida" class="col-form-label fw-bold">Unidad de medida:</label>
                                <input type="text" class="form-control" id="recipient-unidadMedida">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-codigoAlmacenamiento" class="col-form-label fw-bold">Código de
                                    almacenamiento:</label>
                                <input type="text" class="form-control" id="recipient-codigoAlmacenamiento">
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
                                <input type="number" class="form-control" id="recipient-nMueble">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nEstante" class="col-form-label fw-bold">No. de estante:</label>
                                <input type="number" class="form-control" id="recipient-nEstante">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnModalSubmit">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalCancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>