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

    <link rel="stylesheet" href="../../../css/vencimientos.css">

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
                            <h3>Reactivos Caducados</h3>
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
                                        <select class="form-select font-size-12px pt-3" name="slctRowsTable" id="slctRowsTable" aria-label="Floating label select" style="height: 47px !important;">
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
                                            <input type="text" class="form-control border-start-0" id="filtrado" placeholder="Escribe aquí..." style="height: 40px !important;">
                                            <label for="filtrado" class="form-text pt-1">Buscar </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_id" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Caducidad</th>
                                        <th scope="col">No. Mueble</th>
                                        <th scope="col">No. Estante</th>
                                    </tr>
                                </thead>
                                <tbody id="body-table"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted ">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4">
                                <button class="btn btn-outline-primary  mx-auto">Descargar <i class="fas fa-download"></i></button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4">
                                <button id="btn_react_por_caducar" class="btn btn btn-link mx-auto">Ir a reactivos por
                                    caducarse <i class="fas fa-arrow-right"></i> </button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 padding-right-5por padding-left-5por">
                                <nav aria-label="Page navigation example" id="paginationTable">
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- vista reactivos por vencer -->
    <div class="container" id="container-por-caducados">
        <div class="row ">
            <div class="col-12">
                <div class="card text-center shadow animated fadeInLeft mb-3 mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between ">
                            <h3>Reactivos por vencer</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card text-center shadow animated fadeInLeft">
                    <a class="reload-2 ms-auto me-3 mt-2"><i class="fas fa-redo-alt"></i></a>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mt-0 mx-auto">
                                <div class="form-floating ">
                                    <select class="form-select font-size-12px pt-3" name="slctPlazo" id="slctPlazo" aria-label="Floating label select" style="height: 47px !important;">
                                        <option value="7 DAY">Proxima semana.</option>
                                        <option value="1 MONTH">Proximo Mes.</option>
                                        <option value="3 MONTH">Proximos 3 Meses.</option>
                                        <option value="6 MONTH">Proximos 6 Meses.</option>
                                        <option value="1 YEAR">Proximo año.</option>
                                    </select>
                                    <label for="slctPlazo" class="pt-2"> Filtrar por:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mt-0 mb-2">
                                <div class="row">
                                    <div class="form-floating ">
                                        <select class="form-select font-size-12px pt-3" name="slctRowsTable-avencer" id="slctRowsTable-avencer" aria-label="Floating label select" style="height: 47px !important;">
                                            <option value="5">5 registros.</option>
                                            <option value="10">10 registros.</option>
                                            <option value="20">20 registros.</option>
                                            <option value="40">40 registros.</option>
                                            <option value="80">80 registros.</option>
                                            <option value="all">Todos los registros.</option>
                                        </select>
                                        <label for="slctRowsTable-avencer" class="pt-2 ms-2"> Mostrar por:</label>
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
                                            <input type="text" class="form-control border-start-0" id="filtrado-avencer" placeholder="Escribe aquí..." style="height: 40px !important;">
                                            <label for="filtrado-avencer" class="form-text pt-1">Buscar </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_id_avencer" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Caducidad</th>
                                        <th scope="col">No. Mueble</th>
                                        <th scope="col">No. Estante</th>
                                    </tr>
                                </thead>
                                <tbody id="body-table-avencer"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted ">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4">
                                <button class="btn btn-outline-primary  mx-auto">Descargar <i class="fas fa-download"></i></button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4">
                                <button id="btn_react_caducados" class="btn btn btn-link mx-auto"><i class="fas fa-arrow-left"></i> Ir a reactivos Caducados</button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 padding-right-5por padding-left-5por">
                                <nav aria-label="Page navigation example" id="paginationTable-avencer">
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("../../../footer.php"); ?>
    <script type="text/javascript" src="../../../js/vencimientos.js"></script>
</body>

</html>