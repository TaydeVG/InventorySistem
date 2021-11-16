<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">Restablecer Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div class="mb-1">
                                <label class="col-form-label text-muted">Se generará
                                    una nueva contraseña y será enviada al correo especificado.
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="form-floating pb-1">
                                <input type="email"
                                    class="rounded-0 rounded-top form-control border-0 border-bottom border-primary"
                                    id="recipient-mail-retry" name="recipient-mail-retry" placeholder="name@example.com" required
                                    style="height: 40px !important;">
                                <label for="floatingInput" class="form-text pt-1">Correo Electronico</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-evenly">
                <button type="button" class="btn btn-primary" id="btnModalSubmit" data-bs-dismiss="modal">Enviar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                    id="btnModalCancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>