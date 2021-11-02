$(document).ready(function () {
   loadingNotify("", "Cargando");//efecto loading al inicar pagina

   $('#navReactivos').addClass("active-nav");
   $('#navReactivos').attr('href', '#');
   modalLogicLoad();

   var datos = [{
      "id": 1,
      "nombre": "Azul de anilino 1",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "27-10-2021"
   }, {
      "id": 2,
      "nombre": "Azul de anilino 2",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "20-10-2021"
   }, {
      "id": 3,
      "nombre": "Azul de anilino 3",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "27-10-2021"
   }, {
      "id": 4,
      "nombre": "Azul de anilino 4",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "21-10-2021"
   }, {
      "id": 5,
      "nombre": "Azul de anilino 5",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "22-10-2021"
   }, {
      "id": 6,
      "nombre": "Azul de anilino 6",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "27-10-2021"
   }, {
      "id": 7,
      "nombre": "Azul de anilino 6",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "27-10-2021"
   }, {
      "id": 8,
      "nombre": "Azul de anilino 6",
      "reactividad": 1,
      "unidad_medida": "Gramos",
      "caducidad": "No se observa",
      "fecha_alta": "27-10-2021"
   }];
   llenarTabla(datos);
   agregarFiltradoTabla("#tabla_id", "#body-table", "#filtrado", "#paginationTable");

   disableNotifyAlerta();//una vez cargado todo se quita el efecto de loading
   initEvents();
});

function initEvents() {

   // Reload Card
   $('.reload').on('click', function () {

      efectoLoadInSection($('.reload'));

      setTimeout(() => {
         disableEfectoLoadInSection($('.reload'));
      }, 2000);
   });

}

function modalLogicLoad() {
   var modal = document.getElementById('modalId');
   modal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      // Extrae info del atributo data-bs-*

      var recipient = button.getAttribute('data-bs-datos');// se obtiene la informacion de la fila

      var modalTitle = modal.querySelector('.modal-title');
      var modalBodyInput = modal.querySelector('#recipient-nombre');

      modalTitle.textContent = 'New message to ' + recipient;
      modalBodyInput.value = recipient;
   })
}

function llenarTabla(datos) {
   var cantdatos = datos.length;

   $('#body-table').html('');

   for (var i = 0; i < cantdatos; i++) {
      $('#tabla_id').append($(
         ` <tr class="row` + (i + 1) + `  animated fadeInLeft">` +
         `<td class="text-center">` + (i + 1) + `</td>` +
         `<td class="text-center">` + datos[i].nombre + `</td>` +
         `<td class="text-center">` + datos[i].reactividad + `</td>` +
         `<td class="text-center">` + datos[i].unidad_medida + `</td>` +
         `<td class="text-center">` + datos[i].caducidad + `</td>` +
         `<td class="text-center">` + datos[i].fecha_alta + `</td>` +
         `<td class="text-center"> 
               <div class="d-flex justify-content-evenly">
                  <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalId" data-bs-datos="`+datos[i].nombre+`"><i class="fas fa-eye"></i></button>
                  <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalId" data-bs-datos="`+datos[i].nombre+`"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-sm btn-outline-danger btnEliminar" data-id="`+ datos[i].id + `"><i class="fas fa-trash-alt"></i></button> 
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
      enableNotifyYesOrCancel("¿?", "¿Seguro Que Desea Eliminar Este Registro?", 3);
      $("#btnModalYesOrCancel").click(function () {
         $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
            .then(function (data, textStatus, jqXHR) {
               alert("Eliminado = " + idUsuario);
            });
      });

   });

   paginacionTabla('#paginationTable', '#body-table', 1, '#slctRowsTable');

}

