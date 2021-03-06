<div class="card text-center">
    <a class="reload-reactivos ms-auto me-3 mt-2"><i class="fas fa-redo-alt"></i></a>
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mt-0">
                <div class="row">
                    <div class="form-floating ">
                        <select class="form-select font-size-12px pt-3" name="slctRowsTable-reactivos" id="slctRowsTable-reactivos" aria-label="Floating label select" style="height: 47px !important;">
                            <option value="5">5 registros.</option>
                            <option value="10">10 registros.</option>
                            <option value="20">20 registros.</option>
                            <option value="40">40 registros.</option>
                            <option value="80">80 registros.</option>
                            <option value="all">Todos los registros.</option>
                        </select>
                        <label for="slctRowsTable-reactivos" class="pt-2 ms-2"> Mostrar
                            por:</label>
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
                            <input type="text" class="form-control border-start-0" id="filtrado-reactivos" placeholder="Escribe aquí..." style="height: 40px !important;">
                            <label for="filtrado-reactivos" class="form-text pt-1">Buscar </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tabla_id-reactivos" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">fecha de baja</th>
                    </tr>
                </thead>
                <tbody id="body-table-reactivos"></tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted ">
        <div class="row">
            <div class="col-6">
                <form id="formExporterExcel_reactivos">
                    <button type="submit" class="btn btn-outline-primary float-start" id="btn_export_excel_reactivos">Descargar <i class="fas fa-download"></i></button>
                </form>
            </div>
            <div class="col-6 padding-right-5por padding-left-5por">
                <nav aria-label="Page navigation example" id="paginationTable-reactivos">
                </nav>
            </div>
        </div>
    </div>
</div>