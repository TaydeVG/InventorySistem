<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formModal" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="text" class="form-control d-none" id="recipient-id_recipiente" name="id_recipiente" placeholder="">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="" class="img-thumbnail" title="" id="preview" alt="preview" width="100" height="100">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nombre" class="col-form-label fw-bold">Nombre:</label>
                                <input type="text" class="form-control" id="recipient-nombre" name="nombre_recipiente" placeholder="Escribe Aquí" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-capacidad" class="col-form-label fw-bold">Capacidad en:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-capacidad" name="capacidad_recipiente" required>
                                    <option selected disabled value="">Selección</option>
                                    <option value="Volúmen">Volúmen</option>
                                    <option value="Kilogramo">Kilogramo</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-tipo_material" class="col-form-label fw-bold">Tipo de
                                    material:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-tipo_material" name="id_tipo_material_recipiente" required>
                                    <option selected disabled value="">Selección</option>
                                    <option value="0">Otro</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
                                <div class="input-group" id="section_otro_material">
                                    <input type="text" class="form-control" id="recipient-tipo_material_otro" name="nombre_tipo_material_recipiente" placeholder="Escribe Aquí" required>
                                    <button class="btn btn-outline-light text-dark border" type="button" id="btnCambiarMat">X</button>
                                    <div class="invalid-feedback">
                                        Campo invalido.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-id_laboratorio" class="col-form-label fw-bold">Laboratorio:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-id_laboratorio" name="id_laboratorio_recipiente" required>
                                    <option selected disabled value="">Selección</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="recipient-imagen">
                            <label for="recipient-file" class="col-form-label fw-bold">Foto Recipiente:</label>
                            <?php include("../components/drag-and-drop.php"); //el dato se envia por form data 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-evenly">
                    <button type="submit" class="btn btn-outline-primary" id="btnModalSubmit" data-opcion="">Guardar</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" id="btnModalCancel">Cancelar</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnClearModal" onclick="initFormModal(document.getElementById('modalId'))">Limpiar</button>
                </div>
            </form>

        </div>
    </div>
</div>