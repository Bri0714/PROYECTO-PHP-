<?php

#echo "hola mundo";

# importacion del archivo main

require_once "../php-BD/main.php";



# Limpieza de datos 

$nombre = limpiar_cadena($_POST["usuario_nombre"]);
$apellido = limpiar_cadena($_POST["usuario_apellido"]);

$usuario = limpiar_cadena($_POST["usuario_usuario"]);
$email = limpiar_cadena($_POST["usuario_email"]);

$clave_1 = limpiar_cadena($_POST["usuario_clave_1"]);
$clave_2 = limpiar_cadena($_POST["usuario_clave_2"]);

$direccion = limpiar_cadena($_POST["usuario_direccion"]);
$eps = limpiar_cadena($_POST["usuario_EPS"]);

# Validacion de datos 

if($nombre == '' || $apellido == '' || $usuario == '' || $email == '' or $clave_1 == '' || $clave_2 == '' || $direccion == '' || $eps == ''){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit(); # el exit en php se usa para detener la ejecución de un codigo 
}

# Verificando integridad de los datos 

if(validar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no Coincide con el formato solicitado
        </div>
    ';
    exit();
}

if(validar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El APELLIDO no Coincide con el formato solicitado
        </div>
    ';
    exit();
}

if(validar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO no Coincide con el formato solicitado
        </div>
    ';
    exit();
}

if(validar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || validar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las CLAVES no Coincide con el formato solicitado
        </div>
    ';
    exit();
}

# Verificando el email
# para esto utliizamos una funcion la cual es 
# filter_var($email,FILTER_VALIDATE_EMAIL)
# esta funcion nos permite validar un email si es correcto o no
# si es correcto nos devuelve true si no nos devuelve false
# funciona 
# pasando 
# el email que queremos validar
# y el filtro que queremos aplicar
# en este caso FILTER_VALIDATE_EMAIL
# que nos permite validar un email
if($email != ""){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $check_email = conexion();
        $check_email = $check_email->query("SELECT Usuario_email FROM usuario WHERE Usuario_email = '$email'");
        if($check_email->rowCount()>0){
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
    }else{
        
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El EMAIL no es valido
            </div>
        ';
        exit();
    }
}

# ahora se verifica el usuario ya que este debe de ser unico y se debe validar que no exista ya en la base de datos 

# verificando usuario 
if($usuario != ""){
    $check_usuario = conexion();
    $check_usuario = $check_usuario->query("SELECT Usuario_usuario FROM usuario WHERE Usuario_usuario = '$usuario'");
    if($check_usuario->rowCount()>0){
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

# verificando que las claves sean iguales

if($clave_1 != $clave_2){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las CLAVES no coinciden
        </div>
    ';
    exit();
}else{
    #realizaamos la opcion de encriptar la clave para mayor seguridad

    $clave = password_hash($clave_1,PASSWORD_BCRYPT,["COST => 10"] );

}

# verificando EPS

#if(validar_datos("[a-zA-Z0-9$@ .\- ]{4,100}",$eps)){
#    echo '
#        <div class="notification is-danger is-light">
#            <strong>¡Ocurrio un error inesperado!</strong><br>
#            La EPS no Coincide con el formato solicitado
#        </div>
#    ';
#    exit();
#}

# verificando dirección

if(validar_datos("[a-zA-Z0-9$@ .\- ]{7,100}",$direccion)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La DIRECCION no Coincide con el formato solicitado
        </div>
    ';
    exit();
    
}


# ahora se procede a guardar los datos en la base de datos
# GUARDANDO DATOS

# el metodo prepare nos sirve para evitar una consulta con una inyeccion sql 
# en la base de datos
# para esto se debe de hacer una consulta preparada
# la cual se hace de la siguiente manera
# se hace una consulta preparada con el metodo prepare
# y se le pasa la consulta sql que se quiere hacer

#$guardar = conexion();
#$guardar_usuario = $guardar_usuario->prepare("
#
#    INSERT INTO usuario(Usuario_nombre,Usuario_apellido,Usuario_usuario,Usuario_email,Usuario_clave,direccion,EPS)
#    VALUES('$nombre','$apellido','$usuario','$email','$clave','$direccion','$eps')
#    
#    ");
#
# cuando le pasamos una consulta no se pasa directamente los valores por lo cual se pasan marcadores y no van con comillas simples ni variables lo que se hace es lo siguiente 
# se le pasa un marcador de posicion ? y luego se le pasa un array con los valores que se van a insertar en la base de datos
# aca en este lo hacemos con el metodo prepare el cual realiza
# una consulta preparada para evitar la inyección sql
# en la base de datos

$guardar_usuario = conexion();
$guardar_usuario = $guardar_usuario->prepare("

    INSERT INTO usuario(Usuario_nombre,Usuario_apellido,Usuario_usuario,Usuario_email,Usuario_clave,direccion,eps_id)
    VALUES(:nombre,:apellido,:usuario,:email,:clave,:direccion,:eps)
    
    ");

# ahora se le pasan los valores a la consulta preparada por medio del execute
# y se le pasa un array con los valores que se van a insertar en la base de datos

$marcadores = [
    
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":usuario" => $usuario,
        ":email" => $email,
        ":clave" => $clave,
        ":direccion" => $direccion,
        ":eps" => $eps
    
    ];

$guardar_usuario -> execute($marcadores);

if($guardar_usuario -> rowCount() == 1){
    echo '
        <div class="notification is-success is-light">
            <strong>¡Registro Exitoso!</strong><br>
            El usuario se ha registrado correctamente
        </div>
    ';
}else{
    echo '
    
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario no se ha registrado correctamente porfavor intentalo nuevamente.
        </div>
        
    ';
}

# cerra conexión con pdo 
$guardar_usuario = null;

