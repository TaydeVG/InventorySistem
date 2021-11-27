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
                                <input type="email" class="rounded-0 rounded-top form-control border-0 border-bottom border-primary" id="recipient-mail-retry" name="recipient-mail-retry" placeholder="name@example.com" required style="height: 40px !important;">
                                <label for="floatingInput" class="form-text pt-1">Correo Electronico</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-evenly">
                <button type="button" class="btn btn-primary" id="btnModalSubmit" data-bs-dismiss="modal">Enviar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btnModalCancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalIdPassword" tabindex="-1" aria-labelledby="modalIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalIdLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmCambiarPassword">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div class="mb-1">
                                <label class="col-form-label text-center text-muted">Se generó
                                    una contraseña aleatoria recientemente, se le recomienda cambiar de
                                    contraseña.
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 px-5">
                            <div class="d-flex justify-content-end">
                                <div class="form-floating pb-1 w-100">
                                    <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" class="rounded-0 rounded-top form-control border-0 border-bottom border-primary" id="recipient-pass-cambio" name="recipient-pass-cambio" placeholder="Escribe Aquí" minlength="8" maxlength="12" required style="height: 40px !important;">
                                    <label for="floatingInput" class="form-text pt-1">Contraseña</label>
                                </div>
                                <button class="btn btn-sm btn-outline-light text-dark h-75 mt-2 border-0" type="button" id="btnPassword-cambiar">
                                    <i id="iconShowHide" class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <label class=" text-muted ps-2">
                                <li>Al menos 1 mayúscula</li>
                            </label><br>
                            <label class=" text-muted ps-2">
                                <li>Al menos 1 minúscula</li>
                            </label><br>
                            <label class=" text-muted ps-2">
                                <li>Al menos 1 número</li>
                            </label><br>
                            <label class=" text-muted ps-2">
                                <li>Al menos 1 símbolo, símbolo permitido ->! @ # $% ^ & * _ = + -</li>
                            </label><br>
                            <label class=" text-muted ps-2">
                                <li>Mínimo 8 caracteres y máximo 12 caracteres</li>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-evenly">
                    <button type="submit" class="btn btn-primary" id="btnModalPassSubmit">Enviar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalCancel">Recodar mas
                        tarde</button>
                </div>
            </form>

        </div>
    </div>
</div>