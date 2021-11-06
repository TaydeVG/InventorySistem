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
                                <input type="text" class="form-control" id="recipient-nombre"
                                    placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-condicion_uso" class="col-form-label fw-bold">Condicion de
                                    uso:</label>
                                <input type="text" class="form-control" id="recipient-condicion_uso"
                                    placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-mantenimiento"
                                    class="col-form-label fw-bold">Mantenimiento:</label>
                                <input type="number" class="form-control" id="recipient-mantenimiento" min="0" value="0"
                                    placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-num_economico" class="col-form-label fw-bold">No.
                                    Economico:</label>
                                <input type="number" class="form-control" id="recipient-num_economico" min="0" value="0"
                                    placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-num_serie" class="col-form-label fw-bold">No. Serie:</label>
                                <input type="text" class="form-control" id="recipient-num_serie"
                                    placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-id_laboratorio" class="col-form-label fw-bold">Id
                                    Laboratorio:</label>
                                <input type="number" class="form-control" id="recipient-id_laboratorio"
                                    placeholder="Escribe Aquí">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12" id="section-detalle_mant">
                            <div class="mt-3">
                                <a class="btn btn-link" id="btnDetalleMant">Ir a detalle de
                                    mantenimiento</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-evenly">
                <button type="button" class="btn btn-primary" id="btnModalSubmit">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                    id="btnModalCancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>
