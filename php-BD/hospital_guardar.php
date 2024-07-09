<?php 

require_once "main.php";

# Limpieza de datos 

$nombre = limpiar_cadena($_POST["hospital_nombre"]);
$descripcion = limpiar_cadena($_POST["hospital_descripcion"]);

// validar datos 
if($nombre == '' || $descripcion == ''){
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

if($descripcion!=''){
    
    if(validar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9,.#: –\s\-]{3,200}",$descripcion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La DESCRIPCION no Coincide con el formato solicitado
            </div>
        ';
        exit();
    }

}

// verificando nombre del hospital en la base de datos 

$check_nombre = conexion();
$check_nombre = $check_nombre->query("SELECT nombre_hospital FROM hospital WHERE nombre_hospital = '$nombre'");

if($check_nombre->rowCount() > 0){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El nombre del hospital ya se encuentra registrado
        </div>
    ';
    exit();
}

$check_nombre = null;

// guardando datos 

$guardar_hospital = conexion();
$guardar_hospital = $guardar_hospital->prepare("INSERT INTO hospital(nombre_hospital,descripcion_hospital) VALUES (:nombre,:descripcion)");


$marcadores = [
    ':nombre' => $nombre,
    ':descripcion' => $descripcion
];
$guardar_hospital->execute($marcadores);

if($guardar_hospital->rowCount() == 1){

    echo '
        <div class="notification is-success is-light">
            <strong>¡Perfecto!</strong><br>
            El hospital se ha guardado correctamente
        </div>
    ';

}else{

    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El hospital no se ha guardado correctamente, porfavor intentelo nuevamente.
        </div>
    ';

}

$guardar_hospital = null;