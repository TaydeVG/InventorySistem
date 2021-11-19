<nav class="navbar navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        </ul>
        <form class="d-flex">
            <button class="btn text-dark font-size-24px hover" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"> <b>MENÚ</b>
                <i class="fas fa-bars"></i></button>
        </form>
    </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel"><b>MENÚ</b> </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>
            <li class="nav-link">
                <a type="button" data-bs-toggle="collapse" class="btn w-100 text-start"
                    data-bs-target="#multiCollapseExample1" aria-expanded="false"
                    aria-controls="multiCollapseExample1"><i class="fas fa-angle-right"></i>
                    Inventarios</a>
            </li>
        <div class="col">
            <div class="collapse multi-collapse" id="multiCollapseExample1">
                <div class="card card-body border-0">
                    <li class="nav-link">
                        <a href="../reactivos/" class="btn hover w-100 text-start">* Reactivos</a>
                    </li>
                    <li class="nav-link">
                        <a href="../equipos/" class="btn hover w-100 text-start">* Equipos</a>
                    </li>
                    <li class="nav-link">
                        <a href="../recipientes/" class="btn hover w-100 text-start">* Recipientes</a>
                    </li>
                </div>
            </div>
        </div>
        <li class="nav-link">
            <a type="button" data-bs-toggle="collapse" class="btn w-100 text-start"
                data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2"><i
                    class="fas fa-angle-right"></i>
                Reportes</a>
        </li>
        <div class="col">
            <div class="collapse multi-collapse" id="multiCollapseExample2">
                <div class="card card-body border-0">
                    <li class="nav-link">
                        <a href="../reactivos/vencimientos.php" class="btn hover w-100 text-start">* Vencimientos de
                            Reactivos</a>
                    </li>
                    <li class="nav-link">
                        <a href="../reportes/" class="btn hover w-100 text-start">* Reportes de
                            Bajas</a>
                    </li>
                </div>
            </div>
        </div>
        <li class="nav-link">
            <button type="button" class="btn btnCerrarSesion btn-outline-danger w-100 text-start"><i
                    class="fas fa-angle-right"></i> Cerrar
                Sesión</button>
        </li>
        </p>
    </div>
</div>