$(document).ready(function () {
   loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina

   $('#navRecipientes').addClass("active-nav");
   $('#navRecipientes').attr('href', '#');
   modalLogicLoad();

   llenarTabla(getDatosTabla());
   agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");

   LoadTiposMaterial();
   initEvents();
});

function initEvents() {
   $('#section_otro_material').hide();
   // Reload Card
   $('.reload').on('click', function () {

      efectoLoadInSection($('.reload'));
      $.when(llenarTabla(getDatosTabla())).then(function (data, textStatus, jqXHR) {
         setTimeout(() => {
            disableEfectoLoadInSection($('.reload'));
         }, 500);
      });
   });

   $('#btnCambiarMat').click(function (e) {
      $(this).val("");
      $('#section_otro_material').hide();
      $('#recipient-tipo_material').show();
      $('#recipient-tipo_material').val("");
      $('#recipient-tipo_material').focus();
      $('#recipient-tipo_material').attr("required", true);
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
      var capacidad = modal.querySelector('#recipient-capacidad').value;
      var tipo_material = modal.querySelector('#recipient-tipo_material').value;
      var tipo_material_otro = modal.querySelector('#recipient-tipo_material_otro').value;
      var imagen = modal.querySelector('#upl').value;
      var cargoImagen = false;
      //valida si se enviara a guardar una imagen
      if (imagen.length > 0) {//valida que no se envie ese campo si no se carga una imagen
         cargoImagen = true;
      }

      //controla si se guardara por id material o por otro material
      var material = "";
      if (tipo_material == 0) {
         material = tipo_material_otro;
      } else {
         material = tipo_material;
      }

      //valida los datos obligatorios a guardar
      if (nombre.length > 0 && capacidad.length > 0 && material.length > 0) {
         if (formOpcion == "new") {
            console.log("insert");
            insert($(this)[0], cargoImagen);//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
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
            modalTitle.textContent = 'Ingresar datos del recipiente';
            btnModalSubmit.textContent = "Guardar";
            btnModalCancel.textContent = "Cancelar";

            $('#btnModalSubmit').addClass("d-block");
            $('#btnModalSubmit').removeClass("d-none");
            $('#btnClearModal').show();

            break;
         case 'view':
            modalTitle.textContent = 'Informacion del recipiente';
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
            modalTitle.textContent = 'Ingresar datos del recipiente a editar';
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
//recibe como parametro el formulario, NOTA: en el formulario cada input debe tener el atributo name, correspondiente al campo de base de datos
function insert(form, cargoImagen) {
   //se genera form data para poder mandar el archivo file
   var objParam = new FormData(form);

   if (cargoImagen == false) {//valida que no se envie ese campo si no se carga una imagen
      objParam.delete("upl");
   }
   objParam.append("opcion", 6);

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
function initFormModal(modal) {
   $("#formModal").removeClass("was-validated");//elimina las validaciones activas
   $("#formModal")[0].reset();
   $("#closePrev").click();//cierra previsualizador
   deshabilitarFormModal(modal, false);//habilita formulario modal

}
function setFormModal(modal, datos) {
   modal.querySelector('#recipient-nombre').value = datos.nombre;
   modal.querySelector('#recipient-capacidad').value = datos.capacidad;
   modal.querySelector('#recipient-tipo_material').value = datos.tipo_material;
}
function deshabilitarFormModal(modal, isDisabled) {
   modal.querySelector('#recipient-nombre').disabled = isDisabled;
   modal.querySelector('#recipient-capacidad').disabled = isDisabled;
   modal.querySelector('#recipient-tipo_material').disabled = isDisabled;

   if (isDisabled) { //si es true, se deshabilitan inputs
      $('#recipient-nombre,#recipient-capacidad,#recipient-tipo_material').addClass("form-control-plaintext");
      $('#recipient-nombre,#recipient-capacidad,#recipient-tipo_material').removeClass("form-control");
   } else {//si es false, se habilitan inputs
      $('#recipient-nombre,#recipient-capacidad,#recipient-tipo_material').removeClass("form-control-plaintext");
      $('#recipient-nombre,#recipient-capacidad,#recipient-tipo_material').addClass("form-control");
   }
}

function llenarTabla(datos) {
   var cantdatos = datos.length;

   $('#body-table').html('');

   for (var i = 0; i < cantdatos; i++) {
      $('#tabla_id').append($(
         ` <tr class="row` + (i + 1) + ` animated bounceInDown">` +
         `<td class="text-center">` + (i + 1) + `</td>` +
         `<td class="text-center">` + datos[i].nombre + `</td>` +
         `<td class="text-center">` + datos[i].nombre_tipo_material + `</td>` +
         `<td class="text-center">` + datos[i].capacidad + `</td>` +
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
      enableNotifyYesOrCancel("Eliminar recipiente", "¿Está usted seguro de eliminar el recipiente de manera permanente?", 3);
      $("#btnModalYesOrCancel").click(function () {
         $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
            .then(function (data, textStatus, jqXHR) {
               enableNotifyAlerta("Exito!", "¡Recipiente eliminado con exito!", 3);
            });
      });

   });

   paginacionTabla('#paginationTable', '#body-table', 1, '#slctRowsTable');

}

function getDatosTabla() {
   var datos = [];
   var objParam = {
      'opcion': 4
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

function LoadTiposMaterial() {
   // Cargamos los estados
   var tipos_materiales = getTiposMaterial();
   var tipo_material = "<option selected disabled value=''>Selección</option>";

   for (let index = 0; index < tipos_materiales.length; index++) {
      tipo_material = tipo_material + "<option value='" + tipos_materiales[index].id + "'>" + tipos_materiales[index].tipo_material + "</option>";

   }
   tipo_material = tipo_material + "<option value='0'>Otro</option>";

   $('#recipient-tipo_material').html(tipo_material);

   $('#recipient-tipo_material').change(function (e) {
      var value = $(this).val();
      if (value == 0) {
         $('#section_otro_material').show();
         $('#recipient-tipo_material_otro').focus();
         $('#recipient-tipo_material').hide();
         $('#recipient-tipo_material').removeAttr("required");
      } else {
         $('#section_otro_material').hide();
      }
   });
}

function getTiposMaterial() {
   var datos = [];
   var objParam = {
      'opcion': 16
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