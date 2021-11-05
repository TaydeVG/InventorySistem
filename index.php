<?php 
session_start();

    if (isset($_SESSION)) {
        header('location: php/vistas/inicio/principal.php');
    } else {
        header('location: php/vistas/inicio/login.php');
    }
?>