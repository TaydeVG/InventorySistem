<?php 
session_start();
?>
<!doctype html>
<html lang="es">

<head>

  <?php include("../../../header.php"); ?>

  <title>LOGIN</title>
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    #contenedorLoad{
      background-color: white;
      height: 100%;
      width: 100%;
      position: fixed;
      -webkit-transition: all 1s ease;
      -o-transition: all 1s ease;
      transition: all 1s ease;
      z-index: 10000;
    }
  </style>

  <link rel="stylesheet" href="../../../css/login.css">
</head>

<body style="background-color: #EEEEEE;">
  <div id="modalNotifyContainer"></div>

  <div id="contenedorLoad">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <img src="https://iconarchive.com/download/i52489/custom-icon-design/pretty-office-8/Users.ico"
          alt="" width="400" height="400">
        </div>
      </div>
    </div>
  </div>
  <img class="float-end" src="https://iconarchive.com/download/i52489/custom-icon-design/pretty-office-8/Users.ico"
    alt="" width="200" height="200">
  <br><br><br><br>
  <main class="form-signin card border-focus" style="max-width: 430px;">
    <form id="frmLogin">
      <div class="text-center">
        <br>
        <h2 class=" mb-3 fw-normal">BIENVENIDO</h2>
        <hr>
        <h4 class="fw-normal">Inicia Sesión con tu correo electronico</h4>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" id="txtMail" name="txtMail" placeholder="name@example.com" required>
        <label for="floatingInput">Correo Electronico</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Password" required>
        <label for="floatingPassword">Contraseña</label>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me" id="checkRecordar" name="checkRecordar"> Recordar
            </label>
          </div>
        </div>
        <div class="col-6">
          <a href="#" target="_blank" rel="noopener noreferrer">¿Olvidaste tu contraseña?</a>
        </div>
      </div>
      <button class="w-100 btn btn-primary" id="btnLogin" type="submit">Iniciar sesión</button>
      <div class="text-center my-2">
        <label class="w-100">¿Eres nuevo?</label>
      </div>
      <a class="w-100 btn btn-outline-primary" id="btnCrearCuenta" href="../usuarios/alta-usuario.php">Crear cuenta</a>
    </form>
  </main>

  <?php include("../../../footer.php"); ?>
  <script>
    window.onload = function(){
      setTimeout(() => {
        var contenedor = document.getElementById('contenedorLoad');
        contenedor.style.visibility='hidden';
        contenedor.style.opacity = '0';
        
      }, 2000);
    }
    </script>
  <script type="text/javascript" src="../../../js/login.js"></script>
</body>

</html>