<?php

require_once './php-BD/main.php';

$id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0; //id de usuario a actualizar
$id = limpiar_cadena($id)

?>

<div class="container is-fluid mb-6">
    <?php if ($id == $_SESSION["id"]) { ?>
        <h1 class="title">Mi cuenta</h1>
        <h2 class="subtitle">Actualizar datos de la cuenta</h2>
    <?php } else { ?>
        <h1 class="title">Pacientes</h1>
        <h2 class="subtitle">Actualizar Pacientes</h2>
    <?php } ?>
</div>

<div class="container pb-6 pt-6">

    <?php
    include './include/btn_back.php';

    $check_usuario = conexion();
    $check_usuario = $check_usuario->query(" SELECT usuario.*, eps.eps_nombre 
                                            FROM usuario 
                                            LEFT JOIN eps ON usuario.eps_id = eps.eps_id 
                                            WHERE Usuario_id = '$id'");

    if ($check_usuario->rowCount() > 0) {
        $datos = $check_usuario->fetch();
        $usuario_eps_actual = $datos["eps_id"];
    ?>

    <div class="form-rest mb-6 mt-6"></div>

        <form action="./php-BD/usuario_actualizar.php" method="POST" class="Formulario_ajax" autocomplete="off">

            <input type="hidden" name="usuario_id" value="<?php echo $datos["Usuario_id"]; ?>" required>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Nombres</label>
                        <input class="input is-danger has-text-dark" type="text" value="<?php echo $datos["Usuario_nombre"]; ?>" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Apellidos</label>
                        <input class="input is-danger has-text-dark" type="text" value="<?php echo $datos["Usuario_apellido"]; ?>" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Usuario</label>
                        <input class="input is-danger has-text-dark" type="text" name="usuario_usuario" value="<?php echo $datos["Usuario_usuario"]; ?>" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Email</label>
                        <input class="input is-danger has-text-dark" type="email" name="usuario_email" value="<?php echo $datos["Usuario_email"]; ?>" maxlength="70">
                    </div>
                </div>
            </div>
            <div class="column">
                <?php

                echo "</br>";

                require_once "./php-BD/main.php";

                try {
                    $conn = conexion(); // Establecer conexión PDO

                    // Preparar consulta SQL para obtener nombres de EPS
                    $sql = "SELECT eps_id,eps_nombre FROM eps";
                    $stmt = $conn->prepare($sql);

                    // Ejecutar consulta
                    $stmt->execute();

                    // Obtener los nombres de EPS como un arreglo de resultados
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    # el FETCH_ASSOC ES 
                    # una constante de clase que se utiliza para devolver un array indexado por nombre de columna1
                    # en lugar de un array indexado por número de columna (numérico), como lo hace PDO::FETCH_NUM.
                    # FETCH_COLUMN ES 
                    # una constante de clase que se utiliza para devolver una sola columna de la siguiente fila de un conjunto de resultados.

                    if ($results && count($results) > 0) {
                        echo '<div class="control">'; // Contenedor del select de Bulma
                        echo '<div class="select is-small is_focused">'; // Estilo del select de Bulma
                        echo '<select class="is-focused" name="usuario_EPS" value="<?php  echo $datos["Usuario_email"]; ?>"required>'; // Inicio del select
                        echo '<option value="" disabled selected>Seleccionar EPS </option>'; // Opción por defecto
                        foreach ($results as $row) {
                            $eps_id = htmlspecialchars($row['eps_id']);
                            $eps_nombre = htmlspecialchars($row['eps_nombre']);
                            $selected = ($eps_id == $datos['eps_id']) ? 'selected' : ''; // Seleccionar la EPS actual
                            echo '<option value="' . $eps_id . '" ' . $selected . '>' . $eps_nombre . '</option>';
                        }
                        echo '</select>'; // Cierre del select
                        echo '</div>'; // Cierre del contenedor de Bulma
                        echo '</div>'; // Cierre del control
                    } else {
                        echo "No se encontraron registros de EPS.";
                    }
                } catch (PDOException $e) {
                    echo "Error al ejecutar la consulta: " . $e->getMessage();
                }
                ?>
            </div>
            <br><br>
            <p class="has-text-centered">
                SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
            </p>
            <br>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Clave</label>
                        <input class="input is-danger has-text-dark" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Repetir clave</label>
                        <input class="input is-danger has-text-dark" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                    </div>
                </div>
            </div>
            <br><br><br>
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