$('.solo-numeros').on('input', function () { //solo numeros, asignar esta clase al inputa para aplicar validacion
   this.value = this.value.replace(/[^0-9]/g, '');
});
$('.solo-letras').on('input', function () { //solo numeros, asignar esta clase al inputa para aplicar validacion
   this.value = this.value.replace(/[^a-zA-Z ]/g, '');
});
//obtiene y retorna el valor del parametros GET de la URL
function _GET_Param(parametro_get_url) {
   const queryString = window.location.search;
   const urlParams = new URLSearchParams(queryString);
   const data_param = urlParams.get(parametro_get_url);
   return data_param;
}
//aplica validacion al formulario
function aplicarValidacionFormulario(form) {
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
}
//retorna un registro de un arreglo de objetos, buscando por su id
function findRegistroById(id, arrayDatos) {
   const resultado = arrayDatos.find(registro => registro.id == id);
   return resultado;
}

function efectoLoadInSection(sectionAfectada) {
   $(sectionAfectada).parent().append('<div class="opacarContenido texto-centrado fadeIn"><i class="fas fa-sync-alt fa-spin h2" ></i></div>');

   $(sectionAfectada).attr('id', 'reload');
   setTimeout(function () { $(sectionAfectada).attr('id', ''); }, 2000);
}
function disableEfectoLoadInSection(sectionAfectada) {
   $(sectionAfectada).parent().find('.opacarContenido').remove();
}

//agrega logica para filtar datos en tabla a input
function agregarFiltradoTabla(idTabla, idBodyTable, idInputFiltro, idPaginacion) {
   $(idInputFiltro).keyup(function () {
      if ($(this).val() != '') {
         $(idPaginacion).hide();
         $(idBodyTable + ">tr").hide();
         $(idTabla + ' td:contiene-palabra("' + $(this).val() + '")').parent('tr').show();
      }
      else {
         $(idPaginacion).show();
         $('#btnPagSelec').click();
      }

   });

   $.extend($.expr[':'],
      {
         'contiene-palabra': function (elem, i, match, array) {
            return (elem.textContent || elem.innerText || $(elem).text() || '').toLowerCase().indexOf((match[3] || '').toLowerCase()) >= 0;
         }
      });
}
//agrega paginacion a una tabla por sus registros
function paginacionTabla(idTBPaginacion, idTBodyTabla, paginaSelect, idSelctRowsShow) {
   var cantRegistros = $(idTBodyTabla + ' > tr').length;
   $(idTBodyTabla + ' > tr').hide();
   var filasShows = 1;
   var cantFilasMostrar = $(idSelctRowsShow).val();

   if (cantFilasMostrar == "all") {
      cantFilasMostrar = cantRegistros;
   }
   else if (cantFilasMostrar > cantRegistros) {
      cantFilasMostrar = cantRegistros;
   }
   for (var i = 1; i < paginaSelect; i++) {
      filasShows = (filasShows + parseInt(cantFilasMostrar));
   }
   var idRows = 0;
   for (var i = 1; i <= cantFilasMostrar; i++) {
      idRows = (i - 1) + filasShows;
      $('.row' + idRows).show();
   }

   var htmlPaginacion = ``;

   htmlPaginacion = `
     <ul class="pagination pagination-sm justify-content-end" >`;

   if (paginaSelect == 1) {
      htmlPaginacion += `
         <li class="page-item disabled">
           <button class="page-link" aria-label="Previous" id="pgPrevious">
             <span aria-hidden="true">&laquo;</span>
           </button>
         </li>`;
   }
   else {
      htmlPaginacion += `
         <li class="page-item">
           <button class="page-link"  aria-label="Previous" id="pgPrevious">
             <span aria-hidden="true">&laquo;</span>
           </button>
         </li>`;
   }

   var paginas = (cantRegistros / cantFilasMostrar) > parseInt((cantRegistros / cantFilasMostrar), 10) ?
      (parseInt((cantRegistros / cantFilasMostrar)) + 1) : (cantRegistros / cantFilasMostrar);
   var cont = 5;
   for (var i = 1; i <= paginas; i++) {

      if (i == paginaSelect) {
         cont--;
         htmlPaginacion += `
                 <li class="page-item active btnPaginacion" id="btnPagSelec" data-id="`+ i + `"><button class="page-link" disabled="">` + i + `</button></li>
                 `;
      }
      else if (i == (paginas - 1) && paginaSelect != (paginas - 2) && paginaSelect != paginas) {
         htmlPaginacion += `<li class="page-item disabled"><button class="page-link" >...</button></li>`;
      }
      else if ((i == (paginaSelect + 1) || i == (paginaSelect + 2) || i == (paginaSelect - 1)) && cont > 0 || i == paginas || (i == paginas - 2 && paginaSelect == paginas) || (i == paginas - 3 && paginaSelect == paginas) || (i == paginas - 3 && paginaSelect == (paginas - 1))) {
         cont--;
         htmlPaginacion += `
                 <li class="page-item btnPaginacion" data-id="`+ i + `"><button class="page-link" >` + i + `</button></li>
                 `;
      }
   }

   if (paginaSelect == paginas) {
      htmlPaginacion += `
         <li class="page-item disabled">
           <button class="page-link" aria-label="Next" id="pgNext">
             <span aria-hidden="true">&raquo;</span>
           </button>
         </li>`;
   }
   else {
      htmlPaginacion += `
         <li class="page-item">
           <button class="page-link" aria-label="Next" id="pgNext">
             <span aria-hidden="true">&raquo;</span>
           </button>
         </li>`;
   }

   htmlPaginacion += `
     </ul>`;

   $(idTBPaginacion).html(htmlPaginacion);

   $('#pgPrevious').click(function (event) {
      if (paginaSelect > 1) {
         paginacionTabla(idTBPaginacion, idTBodyTabla, (paginaSelect - 1), idSelctRowsShow);
      }
   });
   $('.btnPaginacion').click(function (event) {
      var idPaginacion = $(this).data('id');
      paginacionTabla(idTBPaginacion, idTBodyTabla, idPaginacion, idSelctRowsShow);
   });
   $('#pgNext').click(function (event) {
      if (paginaSelect < paginas) {
         paginacionTabla(idTBPaginacion, idTBodyTabla, (paginaSelect + 1), idSelctRowsShow);
      }
   });
}
//funcion para cerrarSesion del sitio
function cerrarSesion() {
   var datos = [];
   var objParam = {
      'opcion': 0
   };

   $.ajax({
      async: false,
      cache: false,
      url: '../../../php/router_controller.php',
      type: 'POST',
      dataType: 'JSON',
      data: objParam,
      success: function (response) {
         console.log(response);
         //window.location="login.php";
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

//valida que si el usuario se le acaba de generar una contraseña aleatoria por olvido de contraseña, le pida ingresar una nueva
function getUserSesion() {

   var objParam = {
      'opcion': 10,
      "email": localStorage.getItem("user"),
      "password": localStorage.getItem("pass")
   };
   var userSession = null;
   $.ajax({
      async: false,
      cache: false,
      url: '../../../php/router_controller.php',
      type: 'POST',
      dataType: 'JSON',
      data: objParam,
      success: function (response) {
         userSession = response;
         if (response.id > 0 && response.is_password_random == 1) {//solo funciona esta validacion en la vista principal
            //is_password_random =1: significa que utilizo el olvide mi contraseña
            //por lo que se pasa a recomendarle cambiar de contraseña
            setTimeout(() => {
               modalPassword.toggle();
            }, 1000);
         }

         if (response.tipo_usuario != 'admin') {//controla que solo el usuario pueda hacer modificaciones en la base de datos
            //agregar la clase "solo-admin" a los elementos a eliminar del dom
            $('.solo-admin').each(function (index, element) {
               // element == this
               var contenedor = this.parentNode;
               contenedor.removeChild(this);
            });

         }
      },
      beforeSend: function () {
         console.log("get user session");
      },
      error: function (xhr, status, error) {
         console.log(xhr.responseText);
         enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr.responseText + " " + status + " " + error + ".", 4);
      }
   });
   return userSession;
}
