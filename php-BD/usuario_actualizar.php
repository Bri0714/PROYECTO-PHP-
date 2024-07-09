<?php

require_once '../include/session_start.php';

require_once 'main.php';

$id = limpiar_cadena($_POST['usuario_id']);

//Verificar el Usuario

$check_usuario = conexion();

$check_usuario = $check_usuario->query("SELECT * FROM usuario WHERE Usuario_id ='$id'");

if ($check_usuario->rowCount() <= 0) {

    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado </strong><br>
            El usuario que intenta actualizar no existe
        </div>
    ';
    exit();
} else {
    $datos = $check_usuario->fetch();
}
$check_usuario = null;

$admin_usuario = limpiar_cadena($_POST['administrador_usuario']);
$admin_clave = limpiar_cadena($_POST['administrador_clave']);


//Verificando campos obligatorios
if ($admin_usuario == '' || $admin_clave == '') {
    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios que corresponde a su usuario y clave 
        </div>
    ';
    exit();
}

//verificar integridad de los datos 

if (validar_datos("[a-zA-Z0-9]{4,20}", $admin_usuario)) {
    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            SU USUARIO no Coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (validar_datos("[a-zA-Z0-9$@.-]{7,100}", $admin_clave)) {
    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            SU CLAVE no Coincide con el formato solicitado
        </div>
    ';
    exit();
}

//Verificar admin

$check_admin = conexion();

$check_admin = $check_admin->query("SELECT Usuario_usuario,Usuario_clave FROM usuario WHERE Usuario_usuario ='$admin_usuario' AND Usuario_id = '" . $_SESSION['id'] . "'");

if ($check_admin->rowCount() == 1) {
    $check_admin = $check_admin->fetch();

    if ($check_admin['Usuario_usuario'] != $admin_usuario || !password_verify($admin_clave, $check_admin['Usuario_clave'])) {
        echo '
            <div class = "notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario o la clave del administrador incorrectos
            </div>
        ';
        exit();
    }
} else {
    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario o la clave del administrador no coinciden con los datos de la sesión
        </div>
    ';
    exit();
}

$check_admin = null;

# Limpieza de datos 

$nombre = limpiar_cadena($_POST["usuario_nombre"]);
$apellido = limpiar_cadena($_POST["usuario_apellido"]);

$usuario = limpiar_cadena($_POST["usuario_usuario"]);
$email = limpiar_cadena($_POST["usuario_email"]);

$clave_1 = limpiar_cadena($_POST["usuario_clave_1"]);
$clave_2 = limpiar_cadena($_POST["usuario_clave_2"]);

#$direccion = limpiar_cadena($_POST["usuario_direccion"]);

$eps = limpiar_cadena($_POST["usuario_EPS"]);

# Validacion de datos 

if ($nombre == '' || $apellido == '' || $usuario == '' || $email == '' || $eps == '') {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit(); # el exit en php se usa para detener la ejecución de un codigo 
}

# Verificando integridad de los datos

if (validar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El nombre no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (validar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El apellido no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (validar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario no coincide con el formato solicitado
        </div>
    ';
    exit();
}

// validar email

if ($email != "" and $email != $datos['Usuario_email']) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email = conexion();
        $check_email = $check_email->query("SELECT Usuario_email FROM usuario WHERE Usuario_email = '$email'");
        if ($check_email->rowCount() > 0) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El EMAIL ya esta registrado, porfavor elija otro
                </div>
            ';
            exit();
        }
        # ahora se debe cerra la consulta a la base de datos paraa que no consuma la memoria ram
        $check_email = null;
    } else {

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El EMAIL no es valido
            </div>
        ';
        exit();
    }
}

# verificando usuario 
if ($usuario != $datos['Usuario_usuario']) {
    $check_usuario = conexion();
    $check_usuario = $check_usuario->query("SELECT Usuario_usuario FROM usuario WHERE Usuario_usuario = '$usuario'");
    if ($check_usuario->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO ya esta registrado, porfavor elija otro
            </div>
        ';
        exit();
    }
    # ahora se debe cerra la consulta a la base de datos paraa que no consuma la memoria ram
    $check_usuario = null;
}

# verificando claves

if ($clave_1 != '' || $clave_2 != '') {
    if (validar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || validar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVES no Coincide con el formato solicitado
            </div>
        ';
        exit();
    } else {
        if ($clave_1 != $clave_2) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Las CLAVES no coinciden
                </div>
            ';
            exit();
        } else {
            $clave = password_hash(
                $clave_1,
                PASSWORD_BCRYPT,
                ["cost=>10"]
            );
        }
    }
} else {
    $clave = $datos['Usuario_clave'];
}

/// Actualizar datos
$actualizar_usuario = conexion();
$actualizar_usuario = $actualizar_usuario->prepare("UPDATE usuario SET Usuario_nombre=:nombre,Usuario_apellido=:apellido,Usuario_usuario=:usuario,Usuario_clave=:clave,Usuario_email=:email, Eps_id=:eps WHERE Usuario_id=:id");

$marcadores = [
    'nombre' => $nombre,
    'apellido' => $apellido,
    'usuario' => $usuario,
    'clave' => $clave,
    'email' => $email,
    'eps' => $eps,
    'id' => $id // Asegúrate de agregar el ID al array de marcadores
];

if ($actualizar_usuario->execute($marcadores)) {
    echo '
        <div class="notification is-success is-light">
            <strong>¡Felicidades!</strong><br>
            El usuario se ha actualizado correctamente
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario no se ha podido actualizar
        </div>
    ';
}

$actualizar_usuario = null;
