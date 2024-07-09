<?php

$hospital_id_del = limpiar_cadena($_GET['hospital_id_del']);

//verificar usuario

$check_hospital = conexion();

$check_hospital = $check_hospital->query("SELECT id_hospital FROM hospital WHERE id_hospital ='$hospital_id_del'");

if ($check_hospital->rowCount() == 1) {

    $eliminar_hospital = conexion();
    $eliminar_hospital = $eliminar_hospital->prepare('DELETE FROM hospital WHERE id_hospital=:id');

    $marcadores = [
        ":id" => $hospital_id_del,
    ];

    $eliminar_hospital->execute($marcadores);

    // validar eliminacion 

    if ($eliminar_hospital->rowCount() == 1) {
        echo '
            <div class = "notification is-success is-light">
                <strong>Hospital Eliminado</strong><br>
                ¡El Hospital se ha eliminado correctamente!
            </div>
        ';
    } else {
        echo '
            <div class = "notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado </strong><br>
                El Hospital no se ha eliminado,por favor intente nuevamente
            </div>
        ';
    }

    $eliminar_hospital = null;
} else {
    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado </strong><br>
            El Hospital que intenta eliminar no existe
        </div>
    ';
}

$check_hospital = null;
