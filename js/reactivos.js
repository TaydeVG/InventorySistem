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

      var formOpcion = 0;
      switch (opcion) {//dependiendo la accion se aplica logica
         case 'new':
            modalTitle.textContent = 'Ingresar datos del reactivo';
            btnModalSubmit.textContent = "Guardar";
            btnModalCancel.textContent = "Cancelar";

            $('#btnModalSubmit').addClass("d-block");
            $('#btnModalSubmit').removeClass("d-none");

            $('#btnClearModal').show();
            formOpcion = 1; // insert
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

            formOpcion = 2; // update
            break;
         default:
            modalTitle.textContent = 'Se desconoce detonador de modal';
            btnModalSubmit.textContent = "";
            $('#btnClearModal').hide();
            break;
      }
      var form = $("#frmModalReactivos");
      // Loop over them and prevent submission
      Array.prototype.slice.call(form)
         .forEach(function (formInput) {
            formInput.addEventListener('submit', function (event) {
               if (!formInput.checkValidity()) {
                  event.preventDefault()
                  event.stopPropagation()
               }
               formInput.classList.add('was-validated')
            }, false)
         });

      form.submit(function (event) {
         event.preventDefault();

         var nombre = this.querySelector('#recipient-nombre').value;
         var reactividad = this.querySelector('#recipient-reactividad').value;
         var inflamabilida = this.querySelector('#recipient-inflamabilida').value;
         var riesgoSalud = this.querySelector('#recipient-riesgoSalud').value;
         var presentacion = this.querySelector('#recipient-presentacion').value;
         var nReactivo = this.querySelector('#recipient-nReactivo').value;
         var unidadMedida = this.querySelector('#recipient-unidadMedida').value;
         var codigoAlmacenamiento = this.querySelector('#recipient-codigoAlmacenamiento').value;
         var caducidad = this.querySelector('#recipient-caducidad').value;
         var nMueble = this.querySelector('#recipient-nMueble').value;
         var nEstante = this.querySelector('#recipient-nEstante').value;

         if (nombre.length > 0 && reactividad.length > 0 && inflamabilida.length > 0 && riesgoSalud.length > 0 && presentacion.length > 0 && nReactivo.length > 0 && unidadMedida.length > 0 && codigoAlmacenamiento.length > 0 && caducidad.length > 0 && nMueble.length > 0 && nEstante.length > 0) {

            if (formOpcion == 1) {
               console.log("insert");
               this.querySelector("#btnModalCancel").click();//oculta modal al insertar
            } else if (formOpcion == 2) {
               console.log("update");
               this.querySelector("#btnModalCancel").click();//oculta modal al actualizar
            } else {
               console.log("opcion invalida");
            }
         } else {
            console.log("form invalid");
         }

      });
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
