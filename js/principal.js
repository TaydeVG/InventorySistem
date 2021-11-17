var modalPassword = new bootstrap.Modal(document.getElementById('modalIdPassword'), {});

$(document).ready(function () {
    initEventsPrin();
    modalLogicLoad();// carga la logica para cuando se muestre el modal
    getUserSesion();//obtiene el usuario de sesion para ferificarlo
});

function initEventsPrin() {
    $('.btnCerrarSesion').click(function (event) {
        enableNotifyYesOrCancel("¿?", "¿Seguro Que Desea Cerrar Sesion?", 3);
        $("#btnModalYesOrCancel").click(function () {
            $.when(disableNotifyYesOrCancel())// funcion para cerrar el modal a continuacion ira las acciones a seguir
                .then(function (data, textStatus, jqXHR) {
                    cerrarSesion();
                    window.location = "principal.php";
                });
        });

    });

}
function modalLogicLoad() {
    var modal = document.getElementById('modalIdPassword');
    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;//obtiene la info del boton que detono el modal
    });

    $("#btnModalPassSubmit").click(function (e) {
        e.preventDefault();
        var pass = modal.querySelector('#recipient-pass-cambio').value;

        if (pass.length == 8) {
            cambiar_password(pass);
        } else if (pass.length > 0) {
            enableNotifyAlerta("ADVERTENCIA!", "Asegurate de cumplir con la longitud especificada", 5);
            $("#btnModal").click(function () {
                modalPassword.toggle();//vuelve a levantar el modal para capturar la contraseña
            });
        } else {
            enableNotifyAlerta("ADVERTENCIA!", "Todos los campos son obligatorios.", 5);
            $("#btnModal").click(function () {
                modalPassword.toggle();//vuelve a levantar el modal para capturar la contraseña
            });
        }
    });
}
//valida que si el usuario se le acaba de generar una contraseña aleatoria por olvido de contraseña, le pida ingresar una nueva
function getUserSesion() {
    var objParam = {
        'opcion': 10
    };

    $.ajax({
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {
            disableNotifyAlerta();//una vez cargado todo se quita el efecto de loading
            if (response.id > 0 && response.is_password_random == 1) {
                //is_password_random =1: significa que utilizo el olvide mi contraseña
                //por lo que se pasa a recomendarle cambiar de contraseña
                setTimeout(() => {
                    modalPassword.toggle();
                }, 1000);
            }
        },
        beforeSend: function () {
            loadingNotify("Cargando", "Espere un momento por favor...");//efecto loading al inicar pagina
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr.responseText + " " + status + " " + error + ".", 4);
        }
    });
}

function cambiar_password(pass) {
    var objParam = {
        'opcion': 9,
        'password': pass,
    };

    $.ajax({
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {
            console.log(response);

            setTimeout(() => {
                if (response.resultOper == 1) {

                    enableNotifyAlerta("Exito!", response.mensaje, 3);
                    $("#btnModal").click(function () {
                        //  window.location = "principal.php";
                    });
                }
                else {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
                    } else {
                        enableNotifyAlerta("ATENCION!", response.mensaje, 5);
                    }
                }
            }, 1000);
        },
        beforeSend: function () {
            loadingNotify("Cargando", "Espere un momento por favor...");//efecto loading al inicar pagina
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr.responseText + " " + status + " " + error + ".", 4);
        }
    });
}