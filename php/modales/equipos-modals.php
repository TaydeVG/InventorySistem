<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">Titulo modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formModal" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nombre" class="col-form-label fw-bold">Nombre:</label>
                                <input type="text" class="form-control" id="recipient-nombre" name="nombre_equipo" placeholder="Escribe Aquí" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-condicion_uso" class="col-form-label fw-bold">Condicion de
                                    uso:</label>
                                <input type="text" class="form-control" id="recipient-condicion_uso" name="condicion_uso_equipo" placeholder="Escribe Aquí" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-num_economico" class="col-form-label fw-bold">No.
                                    Economico:</label>
                                <input type="number" class="form-control" id="recipient-num_economico" name="num_economico_equipo" min="0" value="0" placeholder="Escribe Aquí" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-num_serie" class="col-form-label fw-bold">No. Serie:</label>
                                <input type="text" class="form-control" id="recipient-num_serie" name="num_serie_equipo" placeholder="Escribe Aquí" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-id_laboratorio" class="col-form-label fw-bold">Laboratorio:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-id_laboratorio" name="id_id_laboratorio_equipo" required>
                                    <option selected disabled value="">Selección</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="recipient-file" class="col-form-label fw-bold">Foto Equipo:</label>
                            <?php include("../components/drag-and-drop.php"); //el dato se envia por form data 
                            ?>
                        </div>
                        <div class="col-12 col-sm-12" id="section-detalle_mant">
                            <div class="mt-3">
                                <a class="btn btn-link" id="btnDetalleMant">Ir a detalle de
                                    mantenimiento</a>
                            </div>
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