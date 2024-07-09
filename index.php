<?php require "./include/session_start.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "include/head.php";
    ?>
</head>

<body>
    <?php

    # comprobacion para saber que vista se va a cargar 
    if (!isset($_GET["vista"]) || $_GET["vista"] == "") {
        $_GET["vista"] = "login";
    }

    # ahora si para cargar una vista dependiendo del valor de la variable get 

    if (is_file("./vistas/" . $_GET["vista"] . ".php") and $_GET["vista"] != "login" and $_GET["vista"] != "404") { # is file es una funcion que nos permite saber si un archivo existe o no si existe en la direccion que se le pone es true si no es false

        # cerar sesion restringir o bloquear acceso al sistema a usuario no logueado 
        if(!isset($_SESSION["id"]) || $_SESSION["id"] == ""){
            include "./vistas/logout.php";
            exit();
        }

        include "./include/navegador.php";

        include "vistas/" . $_GET["vista"] . ".php";

        include "./include/script.php";
    } else {
        if ($_GET["vista"] == "login") {
            include "vistas/login.php";
        } else {
            include "vistas/404.php";
        }
    }

    ?>
    <?php
        include "include/footer.php";
    ?>
</body>

</html>