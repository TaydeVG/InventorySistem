$(document).ready(function () {
    loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina

    $('#navEquipos').addClass("active-nav");
    $('#navEquipos').attr('href', '#');
    modalLogicLoad();

    llenarTabla(getDatosTabla());
    agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");//agrega paginacion a tabla

    LoadLaboratorios();

    initEvents();
    getUserSesion();//valida el dom dependiendo el usuario
    disableNotifyAlerta();//oculta el modal de loading
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

    var btnexport = document.querySelector('#btn_export_excel');
    btnexport.addEventListener("click", async () => {
        exportarExcel()
    });

    var formModal = $("#formModal");
    // controla los mensajes de error o exito en campos formulario
    aplicarValidacionFormulario(formModal);
    //evento de cuando se le da submit al formulario del modal
    formModal.submit(function (e) {
        e.preventDefault();
        var modal = document.getElementById('modalId');
        var formOpcion = document.querySelector('#btnModalSubmit').getAttribute('data-opcion');// se obtiene la opcion del form del modal

        var nombre = modal.querySelector('#recipient-nombre').value;
        var condicion_uso = modal.querySelector('#recipient-condicion_uso').value;
        var num_economico = modal.querySelector('#recipient-num_economico').value;
        var num_serie = modal.querySelector('#recipient-num_serie').value;
        var id_laboratorio = modal.querySelector('#recipient-id_laboratorio').value;

        var imagen = modal.querySelector('#upl').value;
        var cargoImagen = false;
        //valida si se enviara a guardar una imagen
        if (imagen.length > 0) {//valida que no se envie ese campo si no se carga una imagen
            cargoImagen = true;
        }
        //valida los datos obligatorios a guardar
        if (nombre.length > 0 && condicion_uso.length > 0 && num_economico.length > 0 && num_serie.length > 0 && id_laboratorio.length > 0) {
            if (formOpcion == "new") {
                console.log("insert");
                insert_or_update($(this)[0], cargoImagen, "new");//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
                this.querySelector("#btnModalCancel").click();//oculta modal al insertar
            } else if (formOpcion == "edit") {
                console.log("update");
                insert_or_update($(this)[0], cargoImagen, "edit");//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
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
        //muestra la seccion de arrastrar un archivo al iniciar el modal
        $('#recipient-imagen').addClass("d-block");
        $('#recipient-imagen').removeClass("d-none");

        switch (opcion) {//dependiendo la accion se aplica logica
            case 'new':
                modalTitle.textContent = 'Ingresar datos del equipo';
                btnModalSubmit.textContent = "Guardar";
                btnModalCancel.textContent = "Cancelar";

                $('#btnModalSubmit').addClass("d-block");
                $('#btnModalSubmit').removeClass("d-none");

                $('#section-detalle_mant').removeClass("d-block");
                $('#section-detalle_mant').addClass("d-none");

                $('#btnClearModal').show();
                break;
            case 'view':
                modalTitle.textContent = 'Informacion del equipo';
                var id = button.getAttribute('data-bs-id');// se obtiene el id de la fila
                var registro = findRegistroById(id, getDatosTabla());//se obtienen los datos de ese id
                setFormModal(modal, registro);//se carga la informacion en modal
                deshabilitarFormModal(modal, true);//deshabilita formulario modal
                btnModalSubmit.textContent = "Editar";
                btnModalCancel.textContent = "Cerrar";

                $('#btnModalSubmit').removeClass("d-block");
                $('#btnModalSubmit').addClass("d-none");

                $('#section-detalle_mant').addClass("d-block");
                $('#section-detalle_mant').removeClass("d-none");

                //oculta la seccion de arrastras un archivo cuando esta en la opcion de ver
                $('#recipient-imagen').removeClass("d-block");
                $('#recipient-imagen').addClass("d-none");

                $('#btnClearModal').hide();
                break;
            case 'edit':
                modalTitle.textContent = 'Ingresar datos del equipo a editar';
                var id = button.getAttribute('data-bs-id');// se obtiene el id de la fila
                var registro = findRegistroById(id, getDatosTabla());//se obtienen los datos de ese id
                setFormModal(modal, registro);//se carga la informacion en modal
                btnModalSubmit.textContent = "Guardar Cambios";
                btnModalCancel.textContent = "Cancelar";

                $('#btnModalSubmit').addClass("d-block");
                $('#btnModalSubmit').removeClass("d-none");

                $('#section-detalle_mant').removeClass("d-block");
                $('#section-detalle_mant').addClass("d-none");

                $('#btnClearModal').hide();

                break;
            default:
                modalTitle.textContent = 'Se desconoce detonador de modal';
                btnModalSubmit.textContent = "";

                $('#btnClearModal').hide();

                break;
        }
    });
}
//recibe como parametro el formulario, NOTA: en el formulario cada input debe tener el atributo name, correspondiente al campo de base de datos
function insert_or_update(form, cargoImagen, opcion) {
    //se genera form data para poder mandar el archivo file
    var objParam = new FormData(form);

    if (cargoImagen == false) {//valida que no se envie ese campo si no se carga una imagen
        objParam.delete("upl");
    }

    if (opcion == "new") {
        objParam.append("opcion", 18);//opcion del router a ejecutar: insert
    } else {

        objParam.append("imagen_anterior", $('#preview').attr("title"));//para que elimine esta imagen y agregue al servidor la nueva
        objParam.append("opcion", 23);//opcion del router a ejecutar: update
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
            llenarTabla(getDatosTabla());
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
function deleted(id) {
    //se genera form data para poder mandar el request
    var objParam = new FormData();
    objParam.append("id_equipo", id);//opcion del router a ejecutar: update
    objParam.append("opcion", 24);//opcion del router a ejecutar: update

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
            llenarTabla(getDatosTabla());
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

function initFormModal(modal) {
    $('#preview').addClass("d-none");//oculta el contenedor de la imagen cada que se levanta el modal
    modal.querySelector('#preview').src = "";
    modal.querySelector('#preview').title = "";

    $("#formModal").removeClass("was-validated");//elimina las validaciones activas
    $("#formModal")[0].reset();
    $("#closePrev").click();//cierra previsualizador
    deshabilitarFormModal(modal, false);//habilita formulario modal
}

function setFormModal(modal, datos) {
    modal.querySelector('#recipient-id_equipo').value = datos.id;
    modal.querySelector('#recipient-nombre').value = datos.nombre;
    modal.querySelector('#recipient-condicion_uso').value = datos.condicion_uso;
    modal.querySelector('#recipient-num_economico').value = datos.num_economico;
    modal.querySelector('#recipient-num_serie').value = datos.num_serie;
    modal.querySelector('#recipient-id_laboratorio').value = datos.id_laboratorio;
    if (datos.imagen) {
        $('#preview').removeClass("d-none");
        modal.querySelector('#preview').src = "../../../resources/imagenes/imagenes-upload/equipos/" + datos.imagen;
        modal.querySelector('#preview').title = datos.imagen;
    }

    $("#btnDetalleMant").attr("href", "mantenimientos.php?ideq=" + datos.id);//se agrega esta linea para mandar el id por parametros a la vista de mantenimientos
}
function deshabilitarFormModal(modal, isDisabled) {
    modal.querySelector('#recipient-nombre').disabled = isDisabled;
    modal.querySelector('#recipient-condicion_uso').disabled = isDisabled;
    modal.querySelector('#recipient-num_economico').disabled = isDisabled;
    modal.querySelector('#recipient-num_serie').disabled = isDisabled;
    modal.querySelector('#recipient-id_laboratorio').disabled = isDisabled;

    if (isDisabled) { //si es true, se deshabilitan inputs
        $('#recipient-id_equipo,#recipient-nombre,#recipient-fecha_mantenimiento,#recipient-observaciones,#recipient-nombre,#recipient-condicion_uso,#recipient-num_economico,#recipient-num_serie,#recipient-id_laboratorio').addClass("form-control-plaintext");
        $('#recipient-id_equipo,#recipient-nombre,#recipient-fecha_mantenimiento,#recipient-observaciones,#recipient-nombre,#recipient-condicion_uso,#recipient-num_economico,#recipient-num_serie,#recipient-id_laboratorio').removeClass("form-control");
    } else {//si es false, se habilitan inputs
        $('#recipient-id_equipo,#recipient-nombre,#recipient-fecha_mantenimiento,#recipient-observaciones,#recipient-nombre,#recipient-condicion_uso,#recipient-num_economico,#recipient-num_serie,#recipient-id_laboratorio').removeClass("form-control-plaintext");
        $('#recipient-id_equipo,#recipient-nombre,#recipient-fecha_mantenimiento,#recipient-observaciones,#recipient-nombre,#recipient-condicion_uso,#recipient-num_economico,#recipient-num_serie,#recipient-id_laboratorio').addClass("form-control");
    }
}

function llenarTabla(datos) {
    var cantdatos = datos.length;

    $('#body-table').html('');

    for (var i = 0; i < cantdatos; i++) {
        $('#tabla_id').append($(
            ` <tr class="row` + (i + 1) + `  animated bounceInDown">` +
            `<td class="text-center">` + (i + 1) + `</td>` +
            `<td class="text-center">` + datos[i].nombre + `</td>` +
            `<td class="text-center">` + datos[i].condicion_uso + `</td>` +
            `<td class="text-center">` + datos[i].num_economico + `</td>` +
            `<td class="text-center">` + datos[i].num_serie + `</td>` +
            `<td class="text-center"> 
                <div class="d-flex justify-content-evenly">
                   <button class="btn btn-outline-success" title="Ver" data-bs-toggle="modal" data-bs-target="#modalId" data-bs-id="`+ datos[i].id + `" data-bs-opcion="view"><i class="fas fa-eye"></i></button>
                   <button class="btn btn-outline-info solo-admin" title="Editar" data-bs-toggle="modal" data-bs-target="#modalId" data-bs-id="`+ datos[i].id + `" data-bs-opcion="edit"><i class="fas fa-edit"></i></button>
                   <button class="btn btn-sm btn-outline-danger btnEliminar solo-admin" title="Eliminar" data-id="`+ datos[i].id + `"><i class="fas fa-trash-alt"></i></button> 
                </div>
                 </td>`+
            `</tr>`)
        );
    }

    $('#slctRowsTable').change(function (event) {
        llenarTabla(datos);
    });

    $('.btnEliminar').click(function (event) {
        var id = $(this).data('id');
        enableNotifyYesOrCancel("Eliminar equipo", "¿Está usted seguro de eliminar el equipo de manera permanente?", 3);
        $("#btnModalYesOrCancel").click(function () {
            $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
                .then(function (data, textStatus, jqXHR) {
                    deleted(id);
                });
        });

    });

    paginacionTabla('#paginationTable', '#body-table', 1, '#slctRowsTable');

}

function getDatosTabla() {
    var datos = [];
    var objParam = {
        'opcion': 3
    };
    $("#formExporterExcel").hide();
    $.ajax({
        async: false,
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                $("#formExporterExcel").show();
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
            setTimeout(() => {
                console.log("Error En Ajax " + xhr.responseText + " " + status + " " + error + ".");
                enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr + " " + status + " " + error + ".", 4);
            }, 1500);
        }
    });

    return datos;
}

function LoadLaboratorios() {
    // Cargamos los estados
    var laboratorios = getLaboratorios();
    var laboratorio = "<option selected disabled value=''>Selección</option>";

    for (let index = 0; index < laboratorios.length; index++) {
        laboratorio = laboratorio + "<option value='" + laboratorios[index].id + "'>" + laboratorios[index].nombre + "</option>";

    }
    if (laboratorios.length == 0) {
        laboratorio = laboratorio + "<option disabled value=''>favor de registrar un laboratorio para continuar...</option>";
    }

    $('#recipient-id_laboratorio').html(laboratorio);
}

function getLaboratorios() {
    var datos = [];
    var objParam = {
        'opcion': 19
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
            console.log("Error En Ajax " + xhr.responseText + " " + status + " " + error + ".");
            setTimeout(() => {
                enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr + " " + status + " " + error + ".", 4);
            }, 1500);
        }
    });
    return datos;
}

function exportarExcel() {
    try {
        // Send our FormData object; HTTP headers are set automatically
        var formExporterExcel = document.querySelector('#formExporterExcel');
        formExporterExcel.method = "POST";
        formExporterExcel.action = "../../../php/router_controller.php";

        //agrega la opcion del controlador a ejecutar
        var opcion = document.createElement("input");
        opcion.name = "opcion";
        opcion.id = opcion.name;
        opcion.value = 30;
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