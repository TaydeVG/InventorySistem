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
                                <label for="recipient-capacidad" class="col-form-label fw-bold">Capacidad en:</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="recipient-capacidad">
                                    <option selected value="0">Selección</option>
                                    <option value="1">Volúmen</option>
                                    <option value="2">Kilogramo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-tipo_material" class="col-form-label fw-bold">Tipo de
                                    material:</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="recipient-tipo_material">
                                    <option selected value="0">Selección</option>
                                    <option value="1">Vidrio</option>
                                    <option value="2">Plastico</option>
                                    <option value="3">Otro</option>
                                </select>
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