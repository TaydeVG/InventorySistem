$(document).ready(function () {
    loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina

    $('#navEquipos').addClass("active-nav");
    //$('#navEquipos').attr('href', '#');
    modalLogicLoad();


    llenarTabla(getDatosTabla());
    agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");//agrega paginacion a tabla

    disableNotifyAlerta();//una vez cargado todo se quita el efecto de loading
    initEvents();
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
                var registro = findRegistroById(id, getDatosTabla());//se obtienen los datos de ese id
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
                var registro = findRegistroById(id, getDatosTabla());//se obtienen los datos de ese id
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
    modal.querySelector('#recipient-fecha_mantenimiento').value = "";
    modal.querySelector('#recipient-observaciones').value = "";
    deshabilitarFormModal(modal, false);//habilita formulario modal
}

function setFormModal(modal, datos) {
    modal.querySelector('#recipient-fecha_mantenimiento').value = datos.fecha_mantenimiento;
    modal.querySelector('#recipient-observaciones').value = datos.observaciones;
}

function deshabilitarFormModal(modal, isDisabled) {

    modal.querySelector('#recipient-fecha_mantenimiento').disabled = isDisabled;
    modal.querySelector('#recipient-observaciones').disabled = isDisabled;

    if (isDisabled) { //si es true, se deshabilitan inputs
        $('#recipient-fecha_mantenimiento,#recipient-observaciones').addClass("form-control-plaintext");
        $('#recipient-fecha_mantenimiento,#recipient-observaciones').removeClass("form-control");
    } else {//si es false, se habilitan inputs
        $('#recipient-fecha_mantenimiento,#recipient-observaciones').removeClass("form-control-plaintext");
        $('#recipient-fecha_mantenimiento,#recipient-observaciones').addClass("form-control");
    }
}

function llenarTabla(datos) {
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
        llenarTabla(datos);
    });

    $('.btnEliminar').click(function (event) {
        var idUsuario = $(this).data('id');
        enableNotifyYesOrCancel("Eliminar manteniminto", "¿Está usted seguro de eliminar el mantenimiento de manera permanente?", 3);
        $("#btnModalYesOrCancel").click(function () {
            $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
                .then(function (data, textStatus, jqXHR) {
                    alert("Eliminado = " + idUsuario);
                });
        });

    });

    paginacionTabla('#paginationTable', '#body-table', 1, '#slctRowsTable');

}

function getDatosTabla() {
    var datos = [];
    var objParam = {
        'opcion': 5
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