$(document).ready(function () {
   loadingNotify("Espere un momento...", "Cargando");//efecto loading al inicar pagina

   $('#navReactivos').addClass("active-nav");
   $('#navReactivos').attr('href', '#');
   modalLogicLoad();

   llenarTabla(getDatosTabla());
   agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");

   LoadLaboratorios();

   initEvents();
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
      exportarExcel();
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
      var id_laboratorio = modal.querySelector('#recipient-id_laboratorio').value;

      if (nombre.length > 0 && reactividad.length > 0 && inflamabilida.length > 0 && riesgoSalud.length > 0 && presentacion.length > 0 && nReactivo.length > 0 && unidadMedida.length > 0 && codigoAlmacenamiento.length > 0 && caducidad.length > 0 && nMueble.length > 0 && nEstante.length > 0 && id_laboratorio.length > 0) {

         if (formOpcion == "new") {
            console.log("insert");
            insert_or_update($(this)[0], "new");//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
            this.querySelector("#btnModalCancel").click();//oculta modal al insertar
         } else if (formOpcion == "edit") {
            insert_or_update($(this)[0], "edit");//se le envian los campos del formulario, cada name del formulario hace referencia a un campo de base de datos
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
   modal.querySelector('#recipient-id_reactivo').value = datos.id;
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
   modal.querySelector('#recipient-id_laboratorio').value = datos.id_laboratorio;

}
function deshabilitarFormModal(modal, isDisabled) {
   modal.querySelector('#recipient-id_reactivo').disabled = isDisabled;
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
   modal.querySelector('#recipient-id_laboratorio').disabled = isDisabled;

   if (isDisabled) { //si es true, se deshabilitan inputs
      $('#recipient-id_reactivo,#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante,#recipient-id_laboratorio').addClass("form-control-plaintext");
      $('#recipient-id_reactivo,#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante,#recipient-id_laboratorio').removeClass("form-control");
   } else {//si es false, se habilitan inputs
      $('#recipient-id_reactivo,#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante,#recipient-id_laboratorio').removeClass("form-control-plaintext");
      $('#recipient-id_reactivo,#recipient-nombre,#recipient-reactividad,#recipient-inflamabilida,#recipient-riesgoSalud,#recipient-presentacion,#recipient-nReactivo,#recipient-unidadMedida,#recipient-codigoAlmacenamiento,#recipient-caducidad,#recipient-nMueble,#recipient-nEstante,#recipient-id_laboratorio').addClass("form-control");
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
               deleted(id);
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
function insert_or_update(form, opcion) {
   //se genera form data para poder mandar el archivo file
   var objParam = new FormData(form);
   if (opcion == "new") {
      objParam.append("opcion", 17);//opcion del router a ejecutar: insert
   } else {
      objParam.append("opcion", 21);//opcion del router a ejecutar: update
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
   //se genera form data para poder mandar el archivo file
   var objParam = new FormData();
   objParam.append("id_reactivo", id);//opcion del router a ejecutar: update
   objParam.append("opcion", 22);//opcion del router a ejecutar: update

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
      opcion.value = 29;
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