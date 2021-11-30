<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>

    <?php include('../../../header.php'); ?>

    <title>Registro</title>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        #contenedorLoad {
            background-color: white;
            height: 100%;
            width: 100%;
            position: fixed;
            -webkit-transition: all 1s ease;
            -o-transition: all 1s ease;
            transition: all 1s ease;
            z-index: 10000;
        }
    </style>

    <link rel="stylesheet" href="../../../css/login.css">
</head>

<body style="background-color: #EEEEEE;">
    <div id="modalNotifyContainer"></div>

    <img class="float-end rounded-circle shadow-sm" src="../../../resources/imagenes/users_icon.png" alt="" width="200" height="200">
    <br><br><br><br>
    <main class="form-signin w-50" style="min-width: 400px;">
        <form id="frmLogin" class="card border-focus container animated fadeInRight">
            <div class="text-center">
                <br>
                <h2 class=" mb-3 fw-normal">HOLA!!!</h2>
                <hr>
                <h4 class="fw-normal">Crea tu cuenta</h4>
            </div>
            <div class="row">
                <div class="col-6 pb-1">
                    <div class="form-floating">
                        <input type="text" class="solo-letras rounded-0 rounded-top form-control border-0 border-bottom border-primary" id="txtNombre" name="txtNombre" style="height: 40px !important;" placeholder="Nombre(s)" required>
                        <label for="floatingInput" class="form-text pt-1">Nombre(s)</label>
                    </div>
                </div>
                <div class="col-6 pb-1">
                    <div class="form-floating">
                        <input type="text" class="solo-letras rounded-0 rounded-top form-control border-0 border-bottom border-primary" id="txtApellido" name="txtApellido" style="height: 40px !important;" placeholder="Apellido(s)" required>
                        <label for="floatingInput" class="form-text pt-1">Apellido(s)</label>
                    </div>
                </div>
                <div class="col-12 pb-1">
                    <div class="form-floating">
                        <input type="email" class="rounded-0 rounded-top form-control border-0 border-bottom border-primary" id="txtMail" name="txtMail" style="height: 40px !important;" placeholder="name@example.com" required>
                        <label for="floatingInput" class="form-text pt-1">Correo Electronico</label>
                    </div>
                </div>
                <div class="col-12 pb-1">
                    <div class="d-flex justify-content-end">
                        <div class="form-floating pb-0 w-100">
                            <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" class="rounded-0 rounded-top form-control border-0 border-bottom border-primary" id="txtPass" name="txtPass" style="height: 40px !important;" minlength="8" maxlength="12" placeholder="Password" required>
                            <label for="floatingPassword" class="form-text pt-1">Contraseña</label>
                        </div>
                        <button class="btn btn-sm btn-outline-light text-dark h-75 mt-2 border-0" type="button" id="btnPassword">
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

            <button class="w-100 btn btn-primary mt-3" id="btnCrearCuenta" type="submit">Crear cuenta</button>

            <div class="text-center my-2">
                <label class="w-100">¿Ya tienes cuenta? <a class=" btn btn text-primary" id="btnLogin" href="../inicio/login.php">Iniciar sesión</a></label>

            </div>
        </form>
    </main>

    <?php include("../../../footer.php"); ?>
    <script type="text/javascript" src="../../../js/administradores.js"></script>

</body>

</html>