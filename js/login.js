$(document).ready(function () {
    initEvents();

    if (localStorage.getItem("user") && localStorage.getItem("pass")) {
        $('#txtMail').val(localStorage.getItem("user"));
        $('#txtPass').val(localStorage.getItem("pass"));
        this.querySelector("#checkRecordar").checked = true;
    }

    modalLogicLoad();// carga la logica para cuando se muestre el modal

});

function initEvents() {

    $("#frmLogin").submit(function (event) {
        event.preventDefault();
        var email = $("#txtMail").val();
        var password = $("#txtPass").val();
        var recordar = this.querySelector("#checkRecordar").checked;

        validarDatosLogin(email, password, recordar);
    });

    var showPass = false;
    var textPassword = document.querySelector("#txtPass");
    var btnPassword = document.querySelector("#btnPassword");

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
function modalLogicLoad() {
    var modal = document.getElementById('modalId');
    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;//obtiene la info del boton que detono el modal
        var mail = document.querySelector('#txtMail');
        if (mail.value.length > 0) {
            modal.querySelector('#recipient-mail-retry').value = mail.value;
        }

    });

    $("#btnModalSubmit").click(function (e) {
        e.preventDefault();
        var email = modal.querySelector('#recipient-mail-retry').value;
        restablecer_password(email);
    });
}

function restablecer_password(mail) {
    var objParam = {
        'opcion': 8,
        'email': mail,
    };

    $.ajax({
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {
            //disableNotifyAlerta();//una vez cargado todo se quita el efecto de loading
            console.log(response);

            if (response.resultOper == 1) {

                enableNotifyAlerta("Exito!", response.mensaje, 3);
                $("#btnModal").click(function () {
                    //  window.location = "principal.php";
                });
            }
            else {
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
            loadingNotify("Cargando", "Espere un momento por favor...");//efecto loading al inicar pagina
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr.responseText + " " + status + " " + error + ".", 4);
        }
    });
}

function validarDatosLogin(usuario, password, recordar) {
    var objParam = {
        'opcion': 1,
        'email': usuario,
        'password': password,
    };

    $.ajax({
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                if (recordar == true) {
                    localStorage.setItem("user", usuario);
                    localStorage.setItem("pass", password);
                } else {
                    localStorage.removeItem("user");
                    localStorage.removeItem("pass");
                }
                enableNotifyAlerta("Exito!", response.mensaje, 3);
                $("#btnModal").click(function () {
                    window.location = "principal.php";
                });
            }
            else {
                if (response.mensaje.errorInfo) {
                    enableNotifyAlerta("ADVERTENCIA!", response.mensaje.errorInfo[2], 5);
                    console.log(response.mensaje.errorInfo[2]);
                } else {
                    enableNotifyAlerta("Datos Invalidos!", response.mensaje, 5);
                }
            }
            console.log(response);
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