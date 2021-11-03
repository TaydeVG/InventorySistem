<?php 
session_start();
?>
<!doctype html>
<html lang="es">

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

    <img class="float-end" src="../../../resources/imagenes/users_icon.png"
        alt="" width="200" height="200">
    <br><br><br><br>
    <main class="form-signin w-50" style="min-width: 400px;">
        <form id="frmLogin"  class="card border-focus container animated fadeInRight">
            <div class="text-center">
                <br>
                <h2 class=" mb-3 fw-normal">HOLA!!!</h2>
                <hr>
                <h4 class="fw-normal">Crea tu cuenta</h4>
            </div>
            <div class="row">
                <div class="col-6 pe-0">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre(s)"
                            required>
                        <label for="floatingInput">Nombre(s)</label>
                    </div>
                </div>
                <div class="col-6 ps-0">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="txtApellido" name="txtApellido"
                            placeholder="Apellido(s)" required>
                        <label for="floatingInput">Apellido(s)</label>
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="txtMail" name="txtMail"
                            placeholder="name@example.com" required>
                        <label for="floatingInput">Correo Electronico</label>
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-floating pb-0">
                        <input type="password" class="form-control pb-0" id="txtPass" name="txtPass" placeholder="Password"
                            required>
                        <label for="floatingPassword">Contraseña</label>
                    </div>
                    <label class="text-muted ps-2">Minimo 8 caracteres</label>
                </div>
            </div>
           
            <button class="w-100 btn btn-primary mt-3" id="btnCrearCuenta" type="submit">Crear cuenta</button>

            <div class="text-center my-2">
                <label class="w-100">¿Ya tienes cuenta? <a class=" btn btn text-primary" id="btnLogin" href="../inicio/login.php">Iniciar sesión</a></label>
               
            </div>
        </form>
    </main>

    <?php include("../../../footer.php"); ?>

</body>

</html>