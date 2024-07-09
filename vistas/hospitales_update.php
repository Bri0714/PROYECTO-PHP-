<?php

require_once './php-BD/main.php';

$id = (isset($_GET['hospital_id_up'])) ? $_GET['hospital_id_up'] : 0; //id de usuario a actualizar
$id = limpiar_cadena($id)

?>

<div class="container is-fluid mb-6">
        <h1 class="title">Hospitales</h1>
        <h2 class="subtitle">Actualizar datos de los hospitales</h2>
</div>

<div class="body container pb-6 pt-6">

    <?php
    include './include/btn_back.php';

    $check_hospital = conexion();
    $check_hospital = $check_hospital->query(" SELECT *
                                            FROM hospital
                                            WHERE id_hospital = '$id'");

    if ($check_hospital->rowCount() > 0) {
        $datos = $check_hospital->fetch();
    ?>

    <div class="form-rest mb-6 mt-6"></div>

        <form action="./php-BD/hospital_actualizar.php" method="POST" class="Formulario_ajax" autocomplete="off">

            <input type="hidden" name="hospital_id" value="<?php echo $datos["id_hospital"]; ?>" required>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Nombre</label>
                        <input class="input is-danger has-text-dark" type="text" value="<?php echo $datos["nombre_hospital"]; ?>" name="hospital_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Descripcion</label>
                        <textarea class="textarea is-danger has-text-dark" name="hospital_descripcion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9,.#: –\s\-+]{3,200}" required><?php echo $datos["descripcion_hospital"]; ?></textarea>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <p class="has-text-centered">
                Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
            </p>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Usuario</label>
                        <input class="input is-danger has-text-dark" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Clave</label>
                        <input class="input is-danger has-text-dark" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                    </div>
                </div>
            </div>
            <p class="has-text-centered">
                <button type="submit" class="button has-background-danger-dark has-text-light is-rounded">Actualizar</button>
            </p>
        </form>
    <?php } else {
        include './include/error_alert.php';
    }
    ?>
</div>

<style>
    .body {
        position: relative;
        min-height: 70vh;
    }
</style>