$(document).ready(function () {
    initEvents();
    $('#navReactivos').addClass("active-nav");

    if (sessionStorage.getItem("opcion-reactivos") == "acaducar") {
        $('#container-caducados').hide();
        $('#btn_react_por_caducar').click();
        agregarFiltradoTabla("#tabla_id_avencer", "#body-table-avencer", "#filtrado-avencer", "#paginationTable-avencer");
    } else {
        loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina
        $('#container-por-caducados').hide();


        llenarTabla(getDatosTabla());
        agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");

        disableNotifyAlerta();//una vez cargado todo se quita el efecto de loading
    }


});

function initEvents() {
    // Reload Card
    $('.reload').on('click', function () {

        efectoLoadInSection($('.reload'));
        $.when(llenarTabla(getDatosTabla())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                disableEfectoLoadInSection($('.reload'));
            }, 500);
        });
    });
    // Reload Card
    $('.reload-2').on('click', function () {

        efectoLoadInSection($('.reload-2'));
        $.when(llenarTabla_porvencer(getDatosTabla_porvencer())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                disableEfectoLoadInSection($('.reload-2'));
            }, 500);
        });
    });
    $('#btn_react_por_caducar').on('click', function () {
        sessionStorage.setItem("opcion-reactivos", "acaducar");
        loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina
        $('#container-caducados').hide(1000);
        $.when(llenarTabla_porvencer(getDatosTabla_porvencer())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                $('#container-por-caducados').show(1000);
                disableNotifyAlerta();//una vez cargado todo se quita el efecto de loading
            }, 500);
        });
    });
    $('#btn_react_caducados').on('click', function () {
        sessionStorage.setItem("opcion-reactivos", "caducados");

        loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina
        $('#container-por-caducados').hide(1000);
        $.when(llenarTabla(getDatosTabla())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                $('#container-caducados').show(1000);
                disableNotifyAlerta();//una vez cargado todo se quita el efecto de loading
            }, 500);
        });
    });

}

function llenarTabla(datos) {
    var cantdatos = datos.length;

    $('#body-table').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id').append($(
            ` <tr class="row` + (i + 1) + `  animated fadeInLeft">` +
            `<td class="text-center">` + (i + 1) + `</td>` +
            `<td class="text-center">` + datos[i].nombre + `</td>` +
            `<td class="text-center">` + datos[i].caducidad + `</td>` +
            `<td class="text-center">` + datos[i].n_mueble + `</td>` +
            `<td class="text-center">` + datos[i].n_estante + `</td>` +
            `</tr>`)
        );
    }

    $('#slctRowsTable').change(function (event) {
        llenarTabla(datos);
    });

    paginacionTabla('#paginationTable', '#body-table', 1, '#slctRowsTable');

}

function getDatosTabla() {
    var datos = [];
    var objParam = {
        'opcion': 2
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
            }
            else {
                enableNotifyAlerta("ATENCION !", response.mensaje, 5);
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
function llenarTabla_porvencer(datos) {
    var cantdatos = datos.length;

    $('#body-table-avencer').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id_avencer').append($(
            ` <tr class="row` + (i + 1) + `  animated fadeInLeft">` +
            `<td class="text-center">` + (i + 1) + `</td>` +
            `<td class="text-center">` + datos[i].nombre + `</td>` +
            `<td class="text-center">` + datos[i].caducidad + `</td>` +
            `<td class="text-center">` + datos[i].n_mueble + `</td>` +
            `<td class="text-center">` + datos[i].n_estante + `</td>` +
            `</tr>`)
        );
    }

    $('#slctRowsTable-avencer').change(function (event) {
        llenarTabla_porvencer(datos);
    });

    paginacionTabla('#paginationTable-avencer', '#body-table-avencer', 1, '#slctRowsTable-avencer');

}
function getDatosTabla_porvencer() {
    var datos = [];
    var objParam = {
        'opcion': 2
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
            }
            else {
                enableNotifyAlerta("ATENCION !", response.mensaje, 5);
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
