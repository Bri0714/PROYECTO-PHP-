<?php

require_once '../include/session_start.php';

require_once 'main.php';

$id = limpiar_cadena($_POST['hospital_id']);

//Verificar el Usuario

$check_hospital = conexion();

$check_hospital = $check_hospital->query("SELECT * FROM hospital WHERE id_hospital ='$id'");

if ($check_hospital->rowCount() <= 0) {

    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado </strong><br>
            El Hospital que intenta actualizar no existe
        </div>
    ';
    exit();
} else {
    $datos = $check_hospital->fetch();
}
$check_hospital = null;

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

$nombre = limpiar_cadena($_POST["hospital_nombre"]);
$descripcion = limpiar_cadena($_POST["hospital_descripcion"]);

# Validacion de datos 

if ($nombre == '' || $descripcion == '') {
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

if (validar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9,.#: –\s\-+]{3,200}", $descripcion)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La descripción no coincide con el formato solicitado
        </div>
    ';
    exit();
}


/// Actualizar datos
$actualizar_hospital = conexion();
$actualizar_hospital = $actualizar_hospital->prepare("UPDATE hospital SET nombre_hospital=:nombre,descripcion_hospital=:descripcion WHERE id_hospital=:id");

$marcadores = [
    'nombre' => $nombre,
    'descripcion' => $descripcion,
    'id' => $id // Asegúrate de agregar el ID al array de marcadores
];

if ($actualizar_hospital->execute($marcadores)) {
    echo '
        <div class="notification is-success is-light">
            <strong>¡Felicidades!</strong><br>
            El Hospital se ha actualizado correctamente
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El Hospital no se ha podido actualizar
        </div>
    ';
}

$actualizar_hospital = null;
