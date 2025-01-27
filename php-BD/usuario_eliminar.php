<?php

$user_id_del = limpiar_cadena($_GET['user_id_del']);

//verificar usuario

$check_usuario = conexion();

$check_usuario = $check_usuario->query("SELECT Usuario_id FROM usuario WHERE Usuario_id ='$user_id_del'");

if ($check_usuario->rowCount() == 1) {

    $eliminar_usuario = conexion();
    $eliminar_usuario = $eliminar_usuario->prepare('DELETE FROM usuario WHERE Usuario_id=:id');

    $marcadores = [
        ":id" => $user_id_del,
    ];

    $eliminar_usuario->execute($marcadores);

    // validar eliminacion 

    if ($eliminar_usuario->rowCount() == 1) {
        echo '
            <div class = "notification is-success is-light">
                <strong>Usuario Eliminado</strong><br>
                ¡El usuario se ha eliminado correctamente!
            </div>
        ';
    } else {
        echo '
            <div class = "notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado </strong><br>
                El usuario no se ha eliminado,por favor intente nuevamente
            </div>
        ';
    }

    $eliminar_usuario = null;
} else {
    echo '
        <div class = "notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado </strong><br>
            El usuario que intenta eliminar no existe
        </div>
    ';
}

$check_usuario = null;
