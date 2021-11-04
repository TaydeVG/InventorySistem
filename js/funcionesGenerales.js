//retorna un registro de un arreglo de objetos, buscando por su id
function findRegistroById(id, arrayDatos) {
   const resultado = arrayDatos.find(registro => registro.id == id);
   return resultado;
}

function efectoLoadInSection(sectionAfectada) {
    $(sectionAfectada).parent().append('<div class="opacarContenido texto-centrado fadeIn"><i class="fas fa-sync-alt fa-spin h2" ></i></div>');
 
    $('.reload').attr('id', 'reload');
    setTimeout(function () { $('.reload').attr('id', ''); }, 2000);
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