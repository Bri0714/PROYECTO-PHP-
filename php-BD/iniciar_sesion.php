<?php


# el primer paso es almacenar los datos 
# que vienen por el metodo post en variables

$usuario = limpiar_cadena($_POST["login_usuario"]);
$contraseña = limpiar_cadena($_POST["login_contraseña"]);

# verificar campos obligatorios 

if ($usuario !== "" and $contraseña == "") {
    echo '
        <div class="notification is-danger has-text-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        <style>
        .box{
            background-color: #33000A;
            color: white;
        }
        .label{
            color: white;
        }
        .title{
            color: white;
        }
        .button{
            background-color: #6B0015;
        }
    </style>
    ';
    exit();
}

# verificar la integridad de los datos 

if (validar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
        <div class="notification is-danger has-text-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO no Coincide con el formato solicitado
        </div>
        <style>
        .box{
            background-color: #33000A;
            color: white;
        }
        .label{
            color: white;
        }
        .title{
            color: white;
        }
        .button{
            background-color: #6B0015;
        }
    </style>
    ';
    exit();
}

if (validar_datos("[a-zA-Z0-9$@.-]{7,100}", $contraseña)) {
    echo '
        <div class="notification is-danger has-text-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La CONTRASEÑA no Coincide con el formato solicitado
        </div>
        <style>
        .box{
            background-color: #33000A;
            color: white;
        }
        .label{
            color: white;
        }
        .title{
            color: white;
        }
        .button{
            background-color: #6B0015;
        }
    </style>
    ';
    exit();
}

# AHORA SE HACE LA CONSULTA A LA BASE DE DATOS 

$check_user = conexion();
$check_user = $check_user->query("

    SELECT * FROM usuario WHERE Usuario_usuario = '$usuario' 
");

# se verifica si el usuario existe en la base de datos

if ($check_user->rowCount() == 1) {
    $check_user = $check_user->fetch(); # esto nos permite realizar un array de datos mediante la consulta que se ha realizado

    # lo que hace fetch es:
    # devuelve una sola fila de un conjunto de resultados de una consulta preparada

    # ahora validamos la contraseña por medio de la función password_validate que lo que hace es comparar si un texto coincide con una contraseña procesada con password_hash
    if ($check_user["Usuario_usuario"] == $usuario and password_verify($contraseña, $check_user["Usuario_clave"])) {

        # Crearemos todas las variables de sesion 

        $_SESSION["id"] = $check_user["Usuario_id"];
        $_SESSION["nombre"] = $check_user["Usuario_nombre"];
        $_SESSION["apellido"] = $check_user["Usuario_apellido"];
        $_SESSION["usuario"] = $check_user["Usuario_usuario"];

        # redireccionamos al usuario a la pagina de inicio

        # validamos con header sent que sirve para 
        # enviar una cabecera HTTP sin formato al cliente
        # header_sent() nos devuelve un valor booleano
        # si se ha enviado una cabecera nos devuelve un true
        # si no se ha enviado una cabecera nos devuelve un false

        if (headers_sent()) {
            echo "<script>window.location.href='index.php?vista=home';</script>";
        } else {
            header("Location: index.php?vista=home");
        }
    } else {
        echo '
        <div class="notification is-danger has-text-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO o la CONTRASEÑA no coinciden con los datos almacenados en la base de datos
        </div>
        <style>
            .box{
                background-color: #33000A;
                color: white;
            }
            .label{
                color: white;
            }
            .title{
                color: white;
            }
            .button{
                background-color: #6B0015;
            }
        </style>
    ';
        exit();
    }
} else {
    echo '
        <div class="notification is-danger has-text-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO o la CONTRASEÑA no coinciden con los datos almacenados en la base de datos
        </div>
        <style>
            .box{
                background-color: #33000A;
                color: white;
            }
            .label{
                color: white;
            }
            .title{
                color: white;
            }
            .button{
                background-color: #6B0015;
            }
        </style>
    ';
    exit();
}

$check_user = null;
