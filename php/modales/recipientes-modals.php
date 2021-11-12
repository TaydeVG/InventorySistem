<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formModal">
                <div class="modal-body">
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
                                <div class="input-group" id="section_otro_material">
                                    <input type="text" class="form-control" id="recipient-tipo_material_otro"
                                        placeholder="Escribe Aquí">
                                    <button class="btn btn-outline-light text-dark border" type="button"
                                        id="btnCambiarMat">X</button>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <label for="recipient-file" class="col-form-label fw-bold">Foto Equipo:</label>
                            <?php include("../components/drag-and-drop.php");//el dato se envia por form data ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-evenly">
                    <button type="submit" class="btn btn-outline-primary" id="btnModalSubmit">Guardar</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"
                        id="btnModalCancel">Cancelar</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnClearModal"
                        onclick="initFormModal(document.getElementById('modalId'))">Limpiar</button>
                </div>
            </form>

        </div>
    </div>
</div>