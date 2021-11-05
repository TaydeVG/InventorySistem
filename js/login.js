$(document).ready(function () {
    initEvents();

    console.log(localStorage.getItem("user"));
    console.log(localStorage.getItem("pass"));
    if (localStorage.getItem("user") && localStorage.getItem("pass")) {
        $('#txtMail').val(localStorage.getItem("user"));
        $('#txtPass').val(localStorage.getItem("pass"));
        this.querySelector("#checkRecordar").checked = true;
    }
});

function initEvents() {
    $("#frmLogin").submit(function (event) {
        event.preventDefault();
        var email = $("#txtMail").val();
        var password = $("#txtPass").val();
        var recordar = this.querySelector("#checkRecordar").checked;

        validarDatosLogin(email, password, recordar);
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
                    localStorage.setItem("user",usuario);
                    localStorage.setItem("pass", password);
                } else {
                    localStorage.removeItem("user");
                    localStorage.removeItem("pass");
                }
                console.log(response);
                enableNotifyAlerta("Exito!", response.mensaje + " " + response.respuesta.nombre, 3);
                $("#btnModal").click(function () {
                    window.location = "principal.php";
                });
            }
            else {
                enableNotifyAlerta("Datos Invalidos!", response.mensaje, 4);
            }
        },
        beforeSend: function () {
            console.log("cargando peticion");
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            enableNotifyAlerta("ERROR!", "Error En Ajax " + xhr + " " + status + " " + error + ".", 4);
        }
    });

}