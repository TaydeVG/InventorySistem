$(document).ready(function () {
    initEvents();
    $('#navReactivos').addClass("active-nav");

    if (sessionStorage.getItem("opcion-reactivos") == "acaducar") {
        $('#container-caducados').hide();
        $('#btn_react_por_caducar').click();
    } else {
        loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina
        $('#container-por-caducados').hide();


        llenarTabla(getDatosTabla());
    }

    agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");
    agregarFiltradoTabla("#tabla_id_avencer", "#body-table-avencer", "#filtrado-avencer", "#paginationTable-avencer");
    getUserSesion();//valida el dom dependiendo el usuario
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

    var btnexport = document.querySelector('#btn_export_excel_porcaducar');
    btnexport.addEventListener("click", async () => {
        exportarExcel_porcaducar($('#slctPlazo').val());
    });

    var btnexport = document.querySelector('#btn_export_excel_caducados');
    btnexport.addEventListener("click", async () => {
        exportarExcelCaducados();
    });

    // Reload Card
    $('.reload-2').on('click', function () {

        efectoLoadInSection($('.reload-2'));
        $.when(llenarTabla_porvencer(getDatosTabla_porvencer($('#slctPlazo').val()))).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                disableEfectoLoadInSection($('.reload-2'));
            }, 500);
        });
    });
    $('#slctPlazo').change(function (e) {
        e.preventDefault();
        loadingNotify("Espere un momento...", "Cargando");//efecto loading al cambiar de opcion
        llenarTabla_porvencer(getDatosTabla_porvencer($(this).val()));

    });
    $('#btn_react_por_caducar').on('click', function () {
        sessionStorage.setItem("opcion-reactivos", "acaducar");
        loadingNotify("Espere un momento...", "Cargando");//efecto loading al dar click en boton
        $('#container-caducados').hide(1000);
        $.when(llenarTabla_porvencer(getDatosTabla_porvencer($('#slctPlazo').val()))).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                $('#container-por-caducados').show(1000);
            }, 500);
        });
    });
    $('#btn_react_caducados').on('click', function () {
        sessionStorage.setItem("opcion-reactivos", "caducados");

        loadingNotify("Espere un momento...", "Cargando");//efecto loading al dar click en boton
        $('#container-por-caducados').hide(1000);
        $.when(llenarTabla(getDatosTabla())).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                $('#container-caducados').show(1000);
            }, 500);
        });
    });

}

function llenarTabla(datos) {
    var cantdatos = datos.length;

    $('#body-table').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id').append($(
            ` <tr class="row` + (i + 1) + `  animated bounceInDown">` +
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
        'opcion': 11
    };
    $("#formExporterExcel_caducados").hide();

    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                $("#formExporterExcel_caducados").show();
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
function llenarTabla_porvencer(datos) {
    var cantdatos = datos.length;

    $('#body-table-avencer').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id_avencer').append($(
            ` <tr class="row` + (i + 1) + `  animated bounceInDown">` +
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
function getDatosTabla_porvencer(tiempo_faltante_para_caducar) {
    var datos = [];
    var objParam = {
        'opcion': 12,
        'tiempo_para_caducar': tiempo_faltante_para_caducar
    };


    $("#formExporterExcel_porcaducar").hide();
    console.log(objParam);
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
                $("#formExporterExcel_porcaducar").show();
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

function exportarExcelCaducados() {
    try {
        // Send our FormData object; HTTP headers are set automatically
        var formExporterExcel = document.querySelector('#formExporterExcel_caducados');
        formExporterExcel.method = "POST";
        formExporterExcel.action = "../../../php/router_controller.php";

        //agrega la opcion del controlador a ejecutar
        var opcion = document.createElement("input");
        opcion.name = "opcion";
        opcion.id = opcion.name;
        opcion.value = 35;
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

function exportarExcel_porcaducar(tiempo_faltante) {
    try {
        // Send our FormData object; HTTP headers are set automatically
        var formExporterExcel = document.querySelector('#formExporterExcel_porcaducar');
        formExporterExcel.method = "POST";
        formExporterExcel.action = "../../../php/router_controller.php";

        //agrega la opcion del controlador a ejecutar
        var opcion = document.createElement("input");
        opcion.name = "opcion";
        opcion.id = opcion.name;
        opcion.value = 36;
        opcion.classList.add("d-none");
        formExporterExcel.appendChild(opcion);

        var intervalo_tiempo = document.createElement("input");
        intervalo_tiempo.name = "tiempo_para_caducar";
        intervalo_tiempo.id = intervalo_tiempo.name;
        intervalo_tiempo.value = tiempo_faltante;
        intervalo_tiempo.classList.add("d-none");
        formExporterExcel.appendChild(intervalo_tiempo);

        formExporterExcel.submit();

        setTimeout(() => {
            formExporterExcel.removeChild(opcion);
            formExporterExcel.removeChild(intervalo_tiempo);
        }, 2000);

    } catch (error) {
        console.log(error);
        enableNotifyAlerta("ERROR!", error + ".", 4);
    }
}