$(document).ready(function () {
    initEvents()
});

function initEvents() {
    $("#frmLogin").submit(function (event) {
        event.preventDefault();
        var email = $("#txtMail").val();
        var password = $("#txtPass").val();

        validarDatosLogin(email, password);
    });
}

function validarDatosLogin(usuario, password) {
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
                console.log(response);
                enableNotifyAlerta("Exito!", response.mensaje + " " + response.respuesta.nombre, 3);
                $("#btnModal").click(function()
                {
                    window.location="principal.php";
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