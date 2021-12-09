$(document).ready(function () {
    initEvents();
});

function initEvents() {
    $("#frmLogin").submit(function (event) {
        event.preventDefault();

        var txtNombre = $("#txtNombre").val();
        var txtApellido = $("#txtApellido").val();
        var txtMail = $("#txtMail").val();
        var txtPass = $("#txtPass").val();

        if (txtNombre.length > 0 && txtApellido.length > 0 && txtMail.length > 0 && txtPass.length > 0) {
            insert($(this), txtNombre, txtApellido, txtMail, txtPass);
        } else {
            enableNotifyAlerta("ADVERTENCIA!", "Todos los campos son obligatorios.", 5);
        }

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

function insert(form, nombre, apellido, mail, pass) {
    var objParam = {
        'opcion': 7,
        'nombre': nombre,
        'apellido': apellido,
        'email': mail,
        'password': pass
    };

    $.ajax({
        cache: false,
        url: '../../../php/router_controller.php',
        type: 'POST',
        dataType: 'JSON',
        data: objParam,
        success: function (response) {

            if (response.resultOper == 1) {
                enableNotifyAlerta("Exito!", response.mensaje, 3);
                form[0].reset();
            }
            else {
                if (response.mensaje.errorInfo) {
                    enableNotifyAlerta("ADVERTENCIA!", response.mensaje.errorInfo[2], 5);
                    console.log(response.mensaje.errorInfo[2]);
                } else {
                    enableNotifyAlerta("ADVERTENCIA!", response.mensaje, 5);
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