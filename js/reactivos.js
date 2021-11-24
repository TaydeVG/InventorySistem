$(document).ready(function () {
   loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina

   $('#navReactivos').addClass("active-nav");
   $('#navReactivos').attr('href', '#');
   modalLogicLoad();


   llenarTabla(getDatosTabla());
   agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");

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

   var formModal = $("#frmModalReactivos");
   // controla los mensajes de error o exito en campos formulario
   aplicarValidacionFormulario(formModal);

   formModal.submit(function (event) {
      event.preventDefault();
      var modal = document.getElementById('modalId');
      var formOpcion = document.querySelector('#btnModalSubmit').getAttribute('data-opcion');// se obtiene la opcion del form del modal

      var nombre = modal.querySelector('#recipient-nombre').value;
      var reactividad = modal.querySelector('#recipient-reactividad').value;
      var inflamabilida = modal.querySelector('#recipient-inflamabilida').value;
      var riesgoSalud = modal.querySelector('#recipient-riesgoSalud').value;
      var presentacion = modal.querySelector('#recipient-presentacion').value;
      var nReactivo = modal.querySelector('#recipient-nReactivo').value;
      var unidadMedida = modal.querySelector('#recipient-unidadMedida').value;
      var codigoAlmacenamiento = modal.querySelector('#recipient-codigoAlmacenamiento').value;
      var caducidad = modal.querySelector('#recipient-caducidad').value;
      var nMueble = modal.querySelector('#recipient-nMueble').value;
      var nEstante = modal.querySelector('#recipient-nEstante').value;

      if (nombre.length > 0 && reactividad.length > 0 && inflamabilida.length > 0 && riesgoSalud.length > 0 && presentacion.length > 0 && nReactivo.length > 0 && unidadMedida.length > 0 && codigoAlmacenamiento.length > 0 && caducidad.length > 0 && nMueble.length > 0 && nEstante.length > 0) {

         if (formOpcion == "new") {
            console.log("insert");
            insert($(this)[0]);//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
            this.querySelector("#btnModalCancel").click();//oculta modal al insertar
         } else if (formOpcion == "edit") {
            console.log("update");
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
            modalTitle.textContent = 'Ingresar datos del reactivo';
            btnModalSubmit.textContent = "Guardar";
            btnModalCancel.textContent = "Cancelar";

            $('#btnModalSubmit').addClass("d-block");
            $('#btnModalSubmit').removeClass("d-none");

            $('#btnClearModal').show();
            break;
         case 'view':
            modalTitle.textContent = 'Informacion del reactivo';
            var id = button.getAttribute('data-bs-id');// se obtiene el id de la fila
            var registro = findRegistroById(id, getDatosTabla());//se obtienen los datos de ese id
            setFormModal(modal, registro);//se carga la informacion en modal
            deshabilitarFormModal(modal, true);//deshabilita formulario modal
            btnModalSubmit.textContent = "Editar";
            btnModalCancel.textContent = "Cerrar";

            $('#btnModalSubmit').removeClass("d-block");
            $('#btnModalSubmit').addClass("d-none");
            $('#btnClearModal').hide();

            break;
         case 'edit':
            modalTitle.textContent = 'Ingresar datos del reactivo a editar';
            var id = button.getAttribute('data-bs-id');// se obtiene el id de la fila
            var registro = findRegistroById(id, getDatosTabla());//se obtienen los datos de ese id
            setFormModal(modal, registro);//se carga la informacion en modal
            btnModalSubmit.textContent = "Guardar Cambios";
            btnModalCancel.textContent = "Cancelar";

            $('#btnModalSubmit').addClass("d-block");
            $('#btnModalSubmit').removeClass("d-none");
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
function initFormModal(modal) {

   $("#frmModalReactivos").removeClass("was-validated");//elimina las validaciones activas
   $("#frmModalReactivos")[0].reset();//vacia los inputs del form
   deshabilitarFormModal(modal, false);//habilita formulario modal

}
function setFormModal(modal, datos) {
   modal.querySelector('#recipient-nombre').value = datos.nombre;
   modal.querySelector('#recipient-reactividad').value = datos.reactividad;
   modal.querySelector('#recipient-inflamabilida').value = datos.inflamabilida;
   modal.querySelector('#recipient-riesgoSalud').value = datos.riesgo_salud;
   modal.querySelector('#recipient-presentacion').value = datos.presentacion;
   modal.querySelector('#recipient-nReactivo').value = datos.cantidad;
   modal.querySelector('#recipient-unidadMedida').value = datos.unidad_medida;
   modal.querySelector('#recipient-codigoAlmacenamiento').value = datos.codigo_almacenamiento;
   modal.querySelector('#recipient-caducidad').value = datos.caducidad;
   modal.querySelector('#recipient-nMueble').value = datos.n_mueble;
   modal.querySelector('#recipient-nEstante').value = datos.n_estante;
}
function deshabilitarFormModal(modal, isDisabled) {
   modal.querySelector('#recipient-nombre').disabled = isDisabled;
   modal.querySelector('#recipient-reactividad').disabled = isDisabled;
   modal.querySelector('#recipient-inflamabilida').disabled = isDisabled;
   modal.querySelector('#recipient-riesgoSalud').disabled = isDisabled;
   modal.querySelector('#recipient-presentacion').disabled = isDisabled;
   modal.querySelector('#recipient-nReactivo').disabled = isDisabled;
   modal.querySelector('#recipient-unidadMedida').disabled = isDisabled;
   modal.querySelector('#recipient-codigoAlmacenamiento').disabled = isDisabled;
   modal.querySelector('#recipient-caducidad').disabled = isDisabled;
   modal.querySelector('#recipient-nMueble').disabled = isDisabled;
   modal.querySelector('#recipient-nEstante').disabled = isDisabled;

   if (isDisabled) { //si es true, se deshabilitan inputs
      $('#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante').addClass("form-control-plaintext");
      $('#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante').removeClass("form-control");
   } else {//si es false, se habilitan inputs
      $('#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante').removeClass("form-control-plaintext");
      $('#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante').addClass("form-control");
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
         `<td class="text-center">` + datos[i].cantidad + `</td>` +
         `<td class="text-center">` + datos[i].reactividad + `</td>` +
         `<td class="text-center">` + datos[i].inflamabilida + `</td>` +
         `<td class="text-center">` + datos[i].riesgo_salud + `</td>` +
         `<td class="text-center">` + datos[i].unidad_medida + `</td>` +
         `<td class="text-center">` + datos[i].caducidad + `</td>` +
         `<td class="text-center">` + datos[i].n_mueble + `</td>` +
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
      var id = $(this).data('id');
      enableNotifyYesOrCancel("Eliminar Reactivo", "¿Está usted seguro de eliminar el reactivo de manera permanente?", 3);
      $("#btnModalYesOrCancel").click(function () {
         $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
            .then(function (data, textStatus, jqXHR) {
               enableNotifyAlerta("Exito!", "¡Reactivo eliminado con exito!", 3);
            });
      });

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

//recibe como parametro el formulario, NOTA: en el formulario cada input debe tener el atributo name, correspondiente al campo de base de datos
function insert(form) {
   //se genera form data para poder mandar el archivo file
   var objParam = new FormData(form);
   objParam.append("opcion", 17);//opcion del router a ejecutar

   $.ajax({
      cache: false,
      url: '../../../php/router_controller.php',
      type: 'POST',
      dataType: 'JSON',
      data: objParam,
      contentType: false,
      processData: false,
      success: function (response) {

         if (response.resultOper == 1) {

            console.log(response);

         } else {
            console.log(response);
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