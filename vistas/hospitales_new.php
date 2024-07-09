<div class="column p-">
    <div class="container is-fluid mb-4">
        <h1 class="title">Hospitales</h1>
        <h2 class="subtitle">Nuevo Hospital</h2>
    </div>
</div>

<div class="body container pb-6 pt-6">

    <div class="form-rest mb-4 mt-4"></div>

    <form action="./php-BD/hospital_guardar.php" method="POST" class="Formulario_ajax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input is-danger has-text-dark" type="text" name="hospital_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" require>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Descripcion</label>
                    <textarea class="textarea is-danger has-text-dark" name="hospital_descripcion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9,.#: –\s\-]{3,200}" placeholder="Dirección y Telefono de contacto inmediato" required></textarea>
                </div>
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