$(document).ready(function () {
    initEventsPrin();
});

function initEventsPrin() {
    $('.btnCerrarSesion').click(function (event) {
        enableNotifyYesOrCancel("¿?", "¿Seguro Que Desea Cerrar Sesion?", 3);
        $("#btnModalYesOrCancel").click(function () {
            $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
                .then(function (data, textStatus, jqXHR) {
                    window.location="login.php";                   
                });
        });

    });

}