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

    <link rel="stylesheet" href="../../../css/reactvos.css">

    <title>INICIO</title>
</head>

<body style="background-color: #EEEEEE;">
    <?php include("../../../navbar-top.php"); ?>
    <div id="modalNotifyContainer"></div>
    <?php include("../../modales/reactivos-modals.php"); ?>


    <div class="container">
        <div class="row ">
            <div class="col-12">
                <div class="card text-center shadow animated fadeInLeft mb-3 mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between ">
                            <h3> Ractivos </h3>
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalId"
                                data-bs-opcion="new">Nuevo <i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card text-center shadow animated fadeInLeft">
                    <a class="reload ms-auto me-3 mt-2"><i class="fas fa-redo-alt"></i></a>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mt-0">
                                <div class="row">
                                    <div class="form-floating ">
                                        <select class="form-select font-size-12px pt-3" name="slctRowsTable"
                                            id="slctRowsTable" aria-label="Floating label select"
                                            style="height: 47px !important;">
                                            <option value="5">5 registros.</option>
                                            <option value="10">10 registros.</option>
                                            <option value="20">20 registros.</option>
                                            <option value="40">40 registros.</option>
                                            <option value="80">80 registros.</option>
                                            <option value="all">Todos los registros.</option>
                                        </select>
                                        <label for="slctRowsTable" class="pt-2 ms-2"> Mostrar por:</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-9 col-xl-9 ">
                                <div class="row ">
                                    <div class="col-12 col-sm-12 col-md-12 input-group justify-content-end">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <div class=" form-floating ">
                                            <input type="text" class="form-control border-start-0" id="filtrado"
                                                placeholder="Escribe aquí..." style="height: 40px !important;">
                                            <label for="filtrado" class="form-text pt-1">Buscar </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_id" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Reactividad</th>
                                        <th scope="col">Unidad de medida</th>
                                        <th scope="col">Caducidad</th>
                                        <th scope="col">Fecha Alta</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="body-table"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted ">
                        <div class="row">
                            <div class="col-sm-12 padding-right-5por padding-left-5por">
                                <nav aria-label="Page navigation example" id="paginationTable">
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("../../../footer.php"); ?>
    <script type="text/javascript" src="../../../js/reactivos.js"></script>
</body>

</html>