<?php
session_start();
if (isset($_SESSION["usuario"])) { //si hay sesion le permite acceder
} else { //si no hay sesion iniciar lo manda al login
    header("Location: ../inicio/login.php");
    exit;
}
?>
<!doctype html>
<html lang="es">

<head>
    <?php include("../../../header.php"); ?>

    <link rel="stylesheet" href="../../../css/bajas.css">

    <title>INICIO</title>
</head>

<body style="background-color: #EEEEEE;">
    <?php include("../../../navbar-top.php"); ?>
    <div id="modalNotifyContainer"></div>

    <div class="container" id="container-caducados">
        <div class="row ">
            <div class="col-12">
                <div class="card text-center shadow animated fadeInLeft mb-3 mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between ">
                            <h3>Bajas del laboratorio</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class=" text-center shadow animated fadeInLeft">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-reactivos-tab" data-bs-toggle="tab" data-bs-target="#nav-reactivos" type="button" role="tab" aria-controls="nav-reactivos" aria-selected="true">Reactivos</button>
                            <button class="nav-link" id="nav-equipos-tab" data-bs-toggle="tab" data-bs-target="#nav-equipos" type="button" role="tab" aria-controls="nav-equipos" aria-selected="false">Equipos</button>
                            <button class="nav-link" id="nav-recipientes-tab" data-bs-toggle="tab" data-bs-target="#nav-recipientes" type="button" role="tab" aria-controls="nav-recipientes" aria-selected="false">Recipientes</button>
                        </div>
                    </nav>
                    <div class="tab-content card" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-reactivos" role="tabpanel" aria-labelledby="nav-reactivos-tab">
                            <div class="col-12">
                                <?php include("reporte-reactivos.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-equipos" role="tabpanel" aria-labelledby="nav-equipos-tab">
                            <div class="col-12">
                                <?php include("reporte-equipos.php"); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-recipientes" role="tabpanel" aria-labelledby="nav-recipientes-tab">
                            <div class="col-12">
                                <?php include("reporte-recipientes.php"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("../../../footer.php"); ?>
    <script type="text/javascript" src="../../../js/bajas.js"></script>
</body>

</html>