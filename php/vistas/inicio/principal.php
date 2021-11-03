<?php 
session_start();
?>
<!doctype html>
<html lang="es">

<head>
    <?php include("../../../header.php"); ?>

    <title>INICIO</title>

</head>

<body>
    <div id="modalNotifyContainer"></div>

    <?php include("../../../navbar-rigth.php"); ?>

    <div class="container-fluid animated zoomIn">
        <div class="row">
            <div class="col-3 ">
                <img class="rounded-circle img-rotate-infinit d-none d-sm-none d-md-block"
                    src="../../../resources/imagenes/logo.png"
                    alt="imagen" width="300" height="300">
                <img class="rounded-circle img-rotate-infinit d-block d-sm-block d-md-none"
                    src="../../../resources/imagenes/logo.png"
                    alt="imagen" width="100" height="100">
            </div>
            <div class="col-7 text-center">
                <br><br><br class=" d-none d-sm-none d-md-block"><br class=" d-none d-sm-none d-md-block"><br
                    class=" d-none d-sm-none d-md-block">
                <h1>Bienvenido al inventario de laboratorio de química de la Universidad Politécnica del Valle del Évora
                </h1>
            </div>

            <div class="col-12 text-center mt-3">
                <br><br>
                <img src="../../../resources/imagenes/utencilios.png" class="rounded"
                    width="400" alt="">
            </div>
        </div>
    </div>

    <?php include("../../../footer.php"); ?>

    <script type="text/javascript" src="../../../js/principal.js"></script>
</body>

</html>