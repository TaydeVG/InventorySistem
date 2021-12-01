$(document).ready(function () {
    loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina

    $('#navBajas').addClass("active-nav");
    $('#navBajas').attr('href', '#');

    llenarTabla_reactivos(getDatosTabla_reactivos());

    agregarFiltradoTabla("#tabla_id-reactivos", "#body-table-reactivos", "#filtrado-reactivos", "#paginationTable-reactivos");//agrega paginacion a tabla
    agregarFiltradoTabla("#tabla_id-recipientes", "#body-table-recipientes", "#filtrado-recipientes", "#paginationTable-recipientes");//agrega paginacion a tabla
    agregarFiltradoTabla("#tabla_id-equipos", "#body-table-equipos", "#filtrado-equipos", "#paginationTable-equipos");//agrega paginacion a tabla

    initEvents();
});

function initEvents() {

    var btnexport = document.querySelector('#btn_export_excel_reactivos');
    btnexport.addEventListener("click", async () => {
        exportarExcel("reactivos", 32);
    });

    var btnexport = document.querySelector('#btn_export_excel_equipos');
    btnexport.addEventListener("click", async () => {
        exportarExcel("equipos", 33);
    });

    var btnexport = document.querySelector('#btn_export_excel_recipientes');
    btnexport.addEventListener("click", async () => {
        exportarExcel("recipientes", 34);
    });

    // Reload Card
    $('.reload-equipos').on('click', function () {

        efectoLoadInSection($('.reload-equipos'));
        $.when(llenarTabla_equipos(getDatosTabla_equipos())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                disableEfectoLoadInSection($('.reload-equipos'));
            }, 500);
        });
    });
    // Reload Card
    $('.reload-recipientes').on('click', function () {

        efectoLoadInSection($('.reload-recipientes'));
        $.when(llenarTabla_recipientes(getDatosTabla_recipientes())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                disableEfectoLoadInSection($('.reload-recipientes'));
            }, 500);
        });
    });
    // Reload Card
    $('.reload-reactivos').on('click', function () {

        efectoLoadInSection($('.reload-reactivos'));
        $.when(llenarTabla_reactivos(getDatosTabla_reactivos())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                disableEfectoLoadInSection($('.reload-reactivos'));
            }, 500);
        });
    });

    var triggerTabList = [].slice.call(document.querySelectorAll('#nav-tab button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show()
            loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina

            if (tabTrigger._element.id == 'nav-reactivos-tab') {
                llenarTabla_reactivos(getDatosTabla_reactivos());
                console.log("reactivos");
            } else if (tabTrigger._element.id == 'nav-equipos-tab') {

                llenarTabla_equipos(getDatosTabla_equipos());
                console.log("equipos");
            } else if (tabTrigger._element.id == 'nav-recipientes-tab') {
                llenarTabla_recipientes(getDatosTabla_recipientes());
                console.log("recipientes");
            }
        })
    })
}

function llenarTabla_equipos(datos) {
    var cantdatos = datos.length;

    $('#body-table-equipos').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id-equipos').append($(
            ` <tr class="row` + (i + 1) + `  animated bounceInDown">` +
            `<td class="text-center">` + (i + 1) + `</td>` +
            `<td class="text-center">` + datos[i].nombre + `</td>` +
            `<td class="text-center">` + datos[i].num_economico + `</td>` +
            `<td class="text-center">` + datos[i].fecha_baja + `</td>` +
            `</tr>`)
        );
    }

    $('#slctRowsTable_equipos').change(function (event) {
        llenarTabla_equipos(datos);
    });

    paginacionTabla('#paginationTable-equipos', '#body-table-equipos', 1, '#slctRowsTable-equipos');

}
function llenarTabla_recipientes(datos) {
    var cantdatos = datos.length;

    $('#body-table-recipientes').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id-recipientes').append($(
            ` <tr class="row` + (i + 1) + ` animated bounceInDown">` +
            `<td class="text-center">` + (i + 1) + `</td>` +
            `<td class="text-center">` + datos[i].nombre + `</td>` +
            `<td class="text-center">` + datos[i].capacidad + `</td>` +
            `<td class="text-center">` + datos[i].fecha_baja + `</td>` +
            `</tr>`)
        );
    }

    $('#slctRowsTable_recipientes').change(function (event) {
        llenarTabla_recipientes(datos);
    });

    paginacionTabla('#paginationTable-recipientes', '#body-table-recipientes', 1, '#slctRowsTable-recipientes');

}

function getDatosTabla_equipos() {
    var datos = [];
    var objParam = {
        'opcion': 14
    };

    $("#formExporterExcel_equipos").hide();
    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                $("#formExporterExcel_equipos").show();
                datos = response.respuesta;//datos a retornar
                disableNotifyAlerta();//oculta el modal de loading
            } else {
                setTimeout(() => {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
                        console.log(response.mensaje.errorInfo[2]);
                    } else {
                        enableNotifyAlerta("ATENCION!", response.mensaje, 5);
                    }
                }, 1000);
            }
        },
        beforeSend: function () {
            console.log("cargando peticion");
        },
        error: function (xhr, status, error) {

            console.log("Error En Ajax " + xhr.responseText + " " + status + " " + error + ".");
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr + " " + status + " " + error + ".", 4);
        }
    });

    return datos;
}

function getDatosTabla_recipientes() {
    var datos = [];
    var objParam = {
        'opcion': 15
    };
    $("#formExporterExcel_recipientes").hide();
    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                $("#formExporterExcel_recipientes").show();
                datos = response.respuesta;//datos a retornar
                disableNotifyAlerta();//oculta el modal de loading
            } else {
                setTimeout(() => {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
                        console.log(response.mensaje.errorInfo[2]);
                    } else {
                        enableNotifyAlerta("ATENCION!", response.mensaje, 5);
                    }
                }, 1000);
            }
        },
        beforeSend: function () {
            console.log("cargando peticion");
        },
        error: function (xhr, status, error) {

            console.log("Error En Ajax " + xhr.responseText + " " + status + " " + error + ".");
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr + " " + status + " " + error + ".", 4);
        }
    });

    return datos;
}

function llenarTabla_reactivos(datos) {
    var cantdatos = datos.length;

    $('#body-table-reactivos').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id-reactivos').append($(
            ` <tr class="row` + (i + 1) + `  animated bounceInDown">` +
            `<td class="text-center">` + (i + 1) + `</td>` +
            `<td class="text-center">` + datos[i].nombre + `</td>` +
            `<td class="text-center">` + datos[i].cantidad + `</td>` +
            `<td class="text-center">` + datos[i].fecha_baja + `</td>` +
            `</tr>`)
        );
    }

    $('#slctRowsTable-reactivos').change(function (event) {
        llenarTabla_reactivos(datos);
    });

    paginacionTabla('#paginationTable-reactivos', '#body-table-reactivos', 1, '#slctRowsTable-reactivos');

}

function getDatosTabla_reactivos() {
    var datos = [];
    var objParam = {
        'opcion': 13
    };
    $("#formExporterExcel_reactivos").hide();
    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                $("#formExporterExcel_reactivos").show();
                datos = response.respuesta;//datos a retornar
                disableNotifyAlerta();//oculta el modal de loading
            }
            else {
                setTimeout(() => {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
                        console.log(response.mensaje.errorInfo[2]);
                    } else {
                        enableNotifyAlerta("ATENCION!", response.mensaje, 5);
                    }
                }, 1000);
            }
        },
        beforeSend: function () {
            console.log("cargando peticion");
        },
        error: function (xhr, status, error) {

            console.log("Error En Ajax " + xhr.responseText + " " + status + " " + error + ".");
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr + " " + status + " " + error + ".", 4);
        }
    });

    return datos;
}

function exportarExcel(nameForm, opc) {
    try {
        // Send our FormData object; HTTP headers are set automatically
        var formExporterExcel = document.querySelector('#formExporterExcel_' + nameForm);
        formExporterExcel.method = "POST";
        formExporterExcel.action = "../../../php/router_controller.php";

        //agrega la opcion del controlador a ejecutar
        var opcion = document.createElement("input");
        opcion.name = "opcion";
        opcion.id = opcion.name;
        opcion.value = opc;
        opcion.classList.add("d-none");
        formExporterExcel.appendChild(opcion);

        formExporterExcel.submit();

        setTimeout(() => {
            formExporterExcel.removeChild(opcion);
        }, 2000);

    } catch (error) {
        console.log(error);
        enableNotifyAlerta("ERROR!", error + ".", 4);
    }
}
