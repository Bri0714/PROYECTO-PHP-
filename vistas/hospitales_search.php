<div class="container is-fluid mb-6">
    <h1 class="title">Hospitales</h1>
    <h2 class="subtitle">Buscar Hospital</h2>
</div>

<div class="body container pb-6 pt-6">
    <?php

    require_once './php-BD/main.php';

    if (isset($_POST['modulo_buscador'])) {
        require_once "./php-BD/buscador.php";
    }

    if (!isset($_SESSION['busqueda_hospital']) && empty($_SESSION['busqueda_hospital'])) {
    ?>
        <div class="columns">
            <div class="column">
                <form action="" method="POST" autocomplete="off">
                    <input class="input is-danger" type="hidden" name="modulo_buscador" value="hospitales">
                    <div class="field is-grouped ">
                        <p class="control is-expanded">
                            <input class="input is-rounded is-danger has-text-dark" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                        </p>
                        <p class="control">
                            <button class="button has-background-danger-dark has-text-light" type="submit">Buscar</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    <?php
    } else {
    ?>

        <div class="columns">
            <div class="column">
                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_buscador" value="hospitales">
                    <input type="hidden" name="eliminar_buscador" value="hospitales">
                    <p>Estas buscando <strong>
                            <?php echo $_SESSION['busqueda_hospital']; ?>
                        </strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
                </form>
            </div>
        </div>

    <?php

        if (!isset($_GET["page"])) {
            $pagina = 1;
        } else {
            $pagina = (int) $_GET["page"];
            if ($pagina <= 1) {
                $pagina = 1;
            }
        }

        $pagina = limpiar_cadena($pagina);
        $url = "index.php?vista=hospitales_list&page=";
        $registros = 15;
        $busqueda = $_SESSION['busqueda_hospital'];

        require_once "./php-BD/hospital_lista.php";
    }
    ?>
</div>
<style>
    .body {
        position: relative;
        min-height: 70vh;
    }
</style>