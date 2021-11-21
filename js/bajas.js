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

    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                datos = response.respuesta;//datos a retornar
                disableNotifyAlerta();//oculta el modal de loading
            } else {
                setTimeout(() => {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
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

    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                datos = response.respuesta;//datos a retornar
                disableNotifyAlerta();//oculta el modal de loading
            } else {
                setTimeout(() => {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
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

    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                datos = response.respuesta;//datos a retornar
                disableNotifyAlerta();//oculta el modal de loading
            }
            else {
                setTimeout(() => {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
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
