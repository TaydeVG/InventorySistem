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
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsWyRGS1s3mIcw6eEIaDC_cWYKjbpAFWhSvkflj3h3n0Rb8cBIQCbeoq4dXXCnEa2v9VM&usqp=CAU"
                    alt="imagen" width="300" height="300">
                <img class="rounded-circle img-rotate-infinit d-block d-sm-block d-md-none"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsWyRGS1s3mIcw6eEIaDC_cWYKjbpAFWhSvkflj3h3n0Rb8cBIQCbeoq4dXXCnEa2v9VM&usqp=CAU"
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
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFcrl03LY7vpTQZBSMUtwcAw96KzuY2Hg_7w&usqp=CAU"
                    width="400" alt="">
            </div>
        </div>
    </div>

    <?php include("../../../footer.php"); ?>

    <script type="text/javascript" src="../../../js/principal.js"></script>
</body>

</html>