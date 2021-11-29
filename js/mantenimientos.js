
$(document).ready(function () {
    loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina
    var valida_equipo = _GET_Param('ideq') != null ? _GET_Param('ideq').length : 0;
    if (valida_equipo == 0) {//valida que venga un id del equipo como parametros si no lo regresara a equipos
        window.location = "../equipos/";
    }

    $('#navEquipos').addClass("active-nav");
    //$('#navEquipos').attr('href', '#');
    modalLogicLoad();


    llenarTabla(getDatosTabla(_GET_Param('ideq')),_GET_Param('ideq'));
    agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");//agrega paginacion a tabla

    initEvents();
    disableNotifyAlerta();//oculta el modal de loading

});

function initEvents() {
    // Reload Card
    $('.reload').on('click', function () {

        efectoLoadInSection($('.reload'));
        $.when(llenarTabla(getDatosTabla(_GET_Param('ideq')),_GET_Param('ideq'))).then(function (data, textStatus, jqXHR) {
            setTimeout(() => {
                disableEfectoLoadInSection($('.reload'));
            }, 500);
        });
    });

    var formModal = $("#formModal");
    // controla los mensajes de error o exito en campos formulario
    aplicarValidacionFormulario(formModal);
    //evento de cuando se le da submit al formulario del modal
    formModal.submit(function (e) {
        e.preventDefault();
        var modal = document.getElementById('modalId');
        var formOpcion = document.querySelector('#btnModalSubmit').getAttribute('data-opcion');// se obtiene la opcion del form del modal

        var fecha_mantenimiento = modal.querySelector('#recipient-fecha_mantenimiento').value;
        var observaciones = modal.querySelector('#recipient-observaciones').value;

        //valida los datos obligatorios a guardar
        if (fecha_mantenimiento.length > 0 && observaciones.length > 0) {
            if (formOpcion == "new") {
                console.log("insert");
                insert_or_update($(this)[0], _GET_Param('ideq'), "new");//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
                this.querySelector("#btnModalCancel").click();//oculta modal al insertar
            } else if (formOpcion == "edit") {
                console.log("update");
                insert_or_update($(this)[0], _GET_Param('ideq'), "edit");//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
                this.querySelector("#btnModalCancel").click();//oculta modal al actualizar
            } else {
                console.log("opcion invalida");
            }
        } else {
            console.log("form invalid");
        }
    });

}

function modalLogicLoad() {
    var modal = document.getElementById('modalId');
    modal.addEventListener('show.bs.modal', function (event) {
        initFormModal(modal);//reinicia el modal cada que se detona
        var button = event.relatedTarget;//obtiene la info del boton que detono el modal
        var modalTitle = modal.querySelector('.modal-title');
        var btnModalSubmit = modal.querySelector('#btnModalSubmit');
        var btnModalCancel = modal.querySelector('#btnModalCancel');
        // Extrae info del atributo data-bs-*
        var opcion = button.getAttribute('data-bs-opcion');// se obtiene la opcion que levanta el modal

        btnModalSubmit.setAttribute("data-opcion", opcion);
        switch (opcion) {//dependiendo la accion se aplica logica
            case 'new':
                modalTitle.textContent = 'Ingresar datos del mantenimiento';
                btnModalSubmit.textContent = "Guardar";
                btnModalCancel.textContent = "Cancelar";

                $('#btnModalSubmit').addClass("d-block");
                $('#btnModalSubmit').removeClass("d-none");

                break;
            case 'view':
                modalTitle.textContent = 'Informacion del mantenimiento';
                var id = button.getAttribute('data-bs-id');// se obtiene el id de la fila
                var registro = findRegistroById(id, getDatosTabla(_GET_Param('ideq')));//se obtienen los datos de ese id
                setFormModal(modal, registro);//se carga la informacion en modal
                deshabilitarFormModal(modal, true);//deshabilita formulario modal
                btnModalSubmit.textContent = "Editar";
                btnModalCancel.textContent = "Cerrar";

                $('#btnModalSubmit').removeClass("d-block");
                $('#btnModalSubmit').addClass("d-none");

                break;
            case 'edit':
                modalTitle.textContent = 'Ingresar datos del mantenimiento a editar';
                var id = button.getAttribute('data-bs-id');// se obtiene el id de la fila
                var registro = findRegistroById(id, getDatosTabla(_GET_Param('ideq')));//se obtienen los datos de ese id
                setFormModal(modal, registro);//se carga la informacion en modal
                btnModalSubmit.textContent = "Guardar Cambios";
                btnModalCancel.textContent = "Cancelar";

                $('#btnModalSubmit').addClass("d-block");
                $('#btnModalSubmit').removeClass("d-none");

                break;
            default:
                modalTitle.textContent = 'Se desconoce detonador de modal';
                btnModalSubmit.textContent = "";
                break;
        }
    });
}

function initFormModal(modal) {
    $("#formModal").removeClass("was-validated");//elimina las validaciones activas
    $("#formModal")[0].reset();
    deshabilitarFormModal(modal, false);//habilita formulario modal
}

function setFormModal(modal, datos) {
    modal.querySelector('#recipient-id_mantenimiento').value = datos.id;
    modal.querySelector('#recipient-fecha_mantenimiento').value = datos.fecha_mantenimiento.replace(" ", "T");
    modal.querySelector('#recipient-observaciones').value = datos.observaciones;

}

function deshabilitarFormModal(modal, isDisabled) {
    modal.querySelector('#recipient-id_mantenimiento').disabled = isDisabled;

    modal.querySelector('#recipient-fecha_mantenimiento').disabled = isDisabled;
    modal.querySelector('#recipient-observaciones').disabled = isDisabled;

    if (isDisabled) { //si es true, se deshabilitan inputs
        $('#recipient-id_mantenimiento,#recipient-fecha_mantenimiento,#recipient-observaciones').addClass("form-control-plaintext");
        $('#recipient-id_mantenimiento,#recipient-fecha_mantenimiento,#recipient-observaciones').removeClass("form-control");
    } else {//si es false, se habilitan inputs
        $('#recipient-id_mantenimiento,#recipient-fecha_mantenimiento,#recipient-observaciones').removeClass("form-control-plaintext");
        $('#recipient-id_mantenimiento,#recipient-fecha_mantenimiento,#recipient-observaciones').addClass("form-control");
    }
}

function llenarTabla(datos, id_equipo) {
    var cantdatos = datos.length;

    $('#body-table').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id').append($(
            ` <tr class="row` + (i + 1) + `  animated bounceInDown">` +
            `<td class="text-center">` + (i + 1) + `</td>` +
            `<td class="text-center">` + datos[i].fecha_mantenimiento + `</td>` +
            `<td class="text-center">` + datos[i].observaciones + `</td>` +
            `<td class="text-center"> 
                <div class="d-flex justify-content-evenly">
                   <button class="btn btn-outline-success" title="Ver" data-bs-toggle="modal" data-bs-target="#modalId" data-bs-id="`+ datos[i].id + `" data-bs-opcion="view"><i class="fas fa-eye"></i></button>
                   <button class="btn btn-outline-info" title="Editar" data-bs-toggle="modal" data-bs-target="#modalId" data-bs-id="`+ datos[i].id + `" data-bs-opcion="edit"><i class="fas fa-edit"></i></button>
                   <button class="btn btn-sm btn-outline-danger btnEliminar" title="Eliminar" data-id="`+ datos[i].id + `"><i class="fas fa-trash-alt"></i></button> 
                </div>
                 </td>`+
            `</tr>`)
        );
    }

    $('#slctRowsTable').change(function (event) {
        llenarTabla(datos, id_equipo);
    });

    $('.btnEliminar').click(function (event) {
        var id = $(this).data('id');
        enableNotifyYesOrCancel("Eliminar manteniminto", "¿Está usted seguro de eliminar el mantenimiento de manera permanente?", 3);
        $("#btnModalYesOrCancel").click(function () {
            $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
                .then(function (data, textStatus, jqXHR) {
                    deleted(id, id_equipo);
                });
        });

    });

    paginacionTabla('#paginationTable', '#body-table', 1, '#slctRowsTable');

}

function getDatosTabla(id_equipo) {
    var datos = [];
    var objParam = {
        'opcion': 5,
        'id_equipo': id_equipo ? id_equipo : 0
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
            } else {
                setTimeout(() => {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
                        console.log(response.mensaje.errorInfo[2]);
                    } else {
                        enableNotifyAlerta("ATENCION!", response.mensaje, 5);
                    }
                }, 1500);
            }
        },
        beforeSend: function () {
            console.log("cargando peticion");
        },
        error: function (xhr, status, error) {
            //disableNotifyAlerta();//oculta el modal de loading
            setTimeout(() => {
                console.log("Error En Ajax " + xhr.responseText + " " + status + " " + error + ".");
                enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr + " " + status + " " + error + ".", 4);
            }, 1500);
        }
    });

    return datos;
}

//recibe como parametro el formulario, NOTA: en el formulario cada input debe tener el atributo name, correspondiente al campo de base de datos
function insert_or_update(form, id_equipo, opcion) {
    //se genera form data para poder mandar el archivo file
    var objParam = new FormData(form);
    if (opcion == "new") {
        objParam.append("id_equipo_mantenimiento", id_equipo);

        objParam.append("opcion", 20);//opcion del router a ejecutar: insert
    } else {
        objParam.append("opcion", 27);//opcion del router a ejecutar: update
    }

    $.ajax({
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            llenarTabla(getDatosTabla(id_equipo), id_equipo);
            if (response.resultOper == 1) {
                enableNotifyAlerta("Exito!", response.mensaje, 3);
            } else {
                if (response.mensaje.errorInfo) {
                    enableNotifyAlerta("ADVERTENCIA!", response.mensaje.errorInfo[2], 5);
                    console.log(response.mensaje.errorInfo[2]);
                } else {
                    enableNotifyAlerta("ADVERTENCIA!", response.mensaje, 5);
                }
            }

        },
        beforeSend: function () {
            console.log("cargando peticion");
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr.responseText + " " + status + " " + error + ".", 4);
        }
    });
}
function deleted(id, id_equipo) {
    //se genera form data para poder mandar el archivo file
    var objParam = new FormData();
    objParam.append("id_mantenimiento", id);//opcion del router a ejecutar: update
    objParam.append("opcion", 28);//opcion del router a ejecutar: update

    $.ajax({
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            llenarTabla(getDatosTabla(id_equipo),id_equipo);
            if (response.resultOper == 1) {
                enableNotifyAlerta("Exito!", response.mensaje, 3);
            } else {
                if (response.mensaje.errorInfo) {
                    enableNotifyAlerta("ADVERTENCIA!", response.mensaje.errorInfo[2], 5);
                    console.log(response.mensaje.errorInfo[2]);
                } else {
                    enableNotifyAlerta("ADVERTENCIA!", response.mensaje, 5);
                }
            }
        },
        beforeSend: function () {
            console.log("cargando peticion");
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr.responseText + " " + status + " " + error + ".", 4);
        }
    });
}
