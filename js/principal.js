var modalPassword = new bootstrap.Modal(document.getElementById('modalIdPassword'), {});

$(document).ready(function () {
    initEventsPrin();
    modalLogicLoad();// carga la logica para cuando se muestre el modal
    sessionStorage.setItem("opcion-reactivos", "");
    getUserSesion();//obtiene el usuario de sesion para verificarlo
    
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
   
    $("#frmCambiarPassword").submit(function (event) {
        event.preventDefault();
        modalPassword.toggle();
        var pass = modal.querySelector('#recipient-pass-cambio').value;
        cambiar_password(pass);
    });

    var showPass = false;
    var textPassword = document.querySelector("#recipient-pass-cambio");
    var btnPassword = document.querySelector("#btnPassword-cambiar");

    btnPassword.addEventListener('click', function (event) {// controla cuando muestra o oculta el password
        var iconBtn = this.querySelector("#iconShowHide");
        if (showPass) {
            iconBtn.classList.remove("fa-eye");
            iconBtn.classList.add("fa-eye-slash");
            textPassword.setAttribute("type", "password");
        } else {
            iconBtn.classList.add("fa-eye");
            iconBtn.classList.remove("fa-eye-slash");
            textPassword.setAttribute("type", "text");
        }
        showPass = !showPass;
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
                    localStorage.setItem("pass", pass);//se actualiza la contraseña guardada en navegador por la nueva
                }
                else {
                    if (response.mensaje.errorInfo) {
                        enableNotifyAlerta("ATENCION!", response.mensaje.errorInfo[2], 5);
                        console.log(response.mensaje.errorInfo[2]);
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