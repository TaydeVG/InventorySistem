<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmModalReactivos" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="text" class="form-control d-none" id="recipient-id_reactivo" name="id_reactivo" placeholder="">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nombre" class="col-form-label fw-bold">Nombre:</label>
                                <input type="text" class="form-control" id="recipient-nombre" name="nombre_reactivo" placeholder="Escribe Aquí" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-reactividad" class="col-form-label fw-bold">Reactividad:</label>
                                <input type="number" class="form-control" id="recipient-reactividad" name="reactividad_reactivo" min="0" max="4" maxlength="1" value="0" required>
                                <div class="invalid-feedback">
                                    Campo invalido (0-4).
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-inflamabilida" class="col-form-label fw-bold">inflamabilida:</label>
                                <input type="number" class="form-control" id="recipient-inflamabilida" name="inflamabilida_reactivo" min="0" max="4" value="0" maxlength="1" value="0" required>
                                <div class="invalid-feedback">
                                    Campo invalido (0-4).
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-riesgoSalud" class="col-form-label fw-bold">Riesgo a la
                                    salud:</label>
                                <input type="number" class="form-control" id="recipient-riesgoSalud" name="riesgoSalud_reactivo" min="0" max="4" value="0" maxlength="1" value="0" required>
                                <div class="invalid-feedback">
                                    Campo invalido (0-4).
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-presentacion" class="col-form-label fw-bold">Presentación:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-presentacion" name="presentacion_reactivo" required>
                                    <option selected disabled value="">Selección</option>
                                    <option value="Frasco Vidrio">Frasco Vidrio</option>
                                    <option value="Frasco Plástico">Frasco Plástico</option>
                                    <option value="Bidón Vidrio">Bidón Vidrio</option>
                                    <option value="Bidón Plástico">Bidón Plástico</option>
                                    <option value="Galón Vidrio">Galón Vidrio</option>
                                    <option value="Galón Plástico">Galón Plástico</option>
                                    <option value="Bolsa">Bolsa</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nReactivo" class="col-form-label fw-bold">Cantidad de
                                    reactivo:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-nReactivo" name="nReactivo_reactivo" required>
                                    <option selected disabled value="">Selección</option>
                                    <option value="Lleno">Lleno</option>
                                    <option value="Medio">Medio</option>
                                    <option value="Poco">Poco</option>
                                    <option value="Vacio">Vacio</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-unidadMedida" class="col-form-label fw-bold">Unidad de
                                    medida:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-unidadMedida" name="unidadMedida_reactivo" required>
                                    <option selected disabled value="">Selección</option>
                                    <option value="Mililitro">Mililitro</option>
                                    <option value="Gramo">Gramo</option>
                                    <option value="Litro">Litro</option>
                                    <option value="Kilogramo">Kilogramo</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-codigoAlmacenamiento" class="col-form-label fw-bold">Código de
                                    almacenamiento:</label>
                                <div class="input-group">
                                    <select class="form-select" aria-label="Default select example" id="recipient-codigoAlmacenamiento" name="codigoAlmacenamiento_reactivo" required>
                                        <option selected disabled value="">Selección</option>
                                        <option value="Inflamable">Inflamable</option>
                                        <option value="Oxidante">Oxidante</option>
                                        <option value="Corrosivo">Corrosivo</option>
                                        <option value="Tóxico">Tóxico</option>
                                        <option value="No preligroso">No preligroso</option>
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
                                    <div class="invalid-feedback">
                                        Seleccione una opcion.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-caducidad" class="col-form-label fw-bold">Caducidad:</label>
                                <input type="date" class="form-control" id="recipient-caducidad" name="caducidad_reactivo" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nMueble" class="col-form-label fw-bold">No. de mueble:</label>
                                <input type="number" class="form-control" id="recipient-nMueble" name="nMueble_reactivo" placeholder="Escribe Aquí" min="0" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-nEstante" class="col-form-label fw-bold">No. de estante:</label>
                                <input type="number" class="form-control" id="recipient-nEstante" name="nEstante_reactivo" placeholder="Escribe Aquí" min="0" required>
                                <div class="invalid-feedback">
                                    Campo invalido.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="mb-1">
                                <label for="recipient-id_laboratorio" class="col-form-label fw-bold">Laboratorio:</label>
                                <select class="form-select" aria-label="Default select example" id="recipient-id_laboratorio" name="id_laboratorio_reactivo" required>
                                    <option selected disabled value="">Selección</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una opcion.
                                </div>
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