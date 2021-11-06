<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form>
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="mb-1">
                            <label for="recipient-fecha_mantenimiento" class="col-form-label fw-bold">Fecha de
                                mantenimiento:</label>
                            <input type="date" class="form-control" id="recipient-fecha_mantenimiento">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="mb-1">
                            <label for="recipient-observaciones" class="col-form-label fw-bold">Observaciones:</label>
                            <textarea class="form-control" placeholder="Escribe Aquí" id="recipient-observaciones"
                                style="height: 100px"></textarea>
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
