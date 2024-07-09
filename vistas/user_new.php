
<div class="column p-">
    <div class="container is-fluid mb-4">
        <h1 class="title">Pacientes</h1>
        <h2 class="subtitle">Nuevo Paciente</h2>
    </div>
</div>

<div class="body container pb-6 pt-6">

    <div class="form-rest mb-4 mt-4"></div>

    <form action="./php-BD/usuario_guardar.php" method="POST" class="Formulario_ajax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input is-danger has-text-dark" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" require>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input is-danger has-text-dark" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input is-danger has-text-dark" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input is-danger has-text-dark" type="email" name="usuario_email" maxlength="70">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input is-danger has-text-dark" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Repetir clave</label>
                    <input class="input is-danger has-text-dark" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Dirección</label>
                    <input class="input is-danger has-text-dark" type="text" name="usuario_direccion" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
            <!--
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <div class="select is-large">
                            #<?php
#
                            #// Mostrar las opciones de EPS obtenidas de la base de datos
                            #if ($results  && count($results) > 0) {
                            #    echo '<div class="control">'; // Contenedor del select de Bulma
                            #    echo '<div class="select is-large">'; // Estilo del select de Bulma
                            #    echo '<select name="usuario_EPS" required>'; // Inicio del select
                            #    echo '<option value="">Seleccione una EPS</option>'; // Opción por defecto
                            #    foreach ($results as $eps_nombre) {
                            #        echo '<option value="' . htmlspecialchars($eps_nombre) . '">' . htmlspecialchars($eps_nombre) . '</option>';
                            #    }
                            #    echo '</select>'; // Cierre del select
                            #    echo '</div>'; // Cierre del contenedor
                            #    echo '</div>'; // Cierre
                            #}
                            #?>
                            #</select>
                        </div>
                    </div>
                </div>
            </div>
            -->
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
                            echo '<select class="is-focused" name="usuario_EPS" required>'; // Inicio del select
                            echo '<option value="" disabled selected>Seleccionar EPS </option>'; // Opción por defecto
                            foreach ($results as $row) {
                                $eps_id = htmlspecialchars($row['eps_id']);
                                $eps_nombre = htmlspecialchars($row['eps_nombre']);
                                echo '<option value="' . $eps_id . '">' . $eps_nombre . '</option>';
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
            </div>

            <p class="has-text-centered">
                <button type="submit" class="button is-rounded has-background-danger-dark has-text-light">Guardar</button>
            </p>
    </form>
</div>

<style>
    .body {
        position: relative;
        min-height: 70vh;
    }
</style>