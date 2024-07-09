<style>
    /* Estilos para la imagen de fondo y el clip path */
    .figure {
        position: relative;
        height: 100vh;
        overflow: hidden;
        /* Ocultar contenido que se salga del contenedor */
    }

    .clip-path {
        width: 100%;
        height: 100%;
        object-fit: cover;
        clip-path: polygon(0 0, 100% 0, 100% 80%, 50% 100%, 0 80%);
        /* Definición de clip path para recortar la imagen */
    }

    .figure_img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ajustar la imagen al tamaño del contenedor */
        position: relative;
    }

    .figure-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        /* Fondo semi-transparente para el overlay*/
    }

    .figure-content {
        text-align: center;
        z-index: 1;
        color: #fff;
        /* Color de texto blanco */
    }

    /* Estilos adicionales para el botón */
    .boton {
        margin-top: 20px;
        /* Espacio superior para separar el botón del texto */
    }
</style>
<div class="column p-">
    <div class="container is-fluid mb-4">
        <h1 class="title">¡Home</h1>
        <h2 class="subtitle"><?php echo "Bienvenido usuario" . " " . $_SESSION["nombre"] ?></h2>
    </div>
</div>

<figure class="figure">
    <img src="img/triage2.jpg" class="figure_img clip-path" alt="imagen de saludcheck">
    <div class="figure-overlay">
        <div class="figure-content">
            <h3 class="is-size-3 has-text-white">SaludCheck</h3>
            <button id="btn-comenzar" class="button boton is-rounded has-background-danger-dark has-text-light">Comienza ahora</button>
        </div>
    </div>
</figure>


<section id="criterios" class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <h2 class="title">Criterios de Evaluación para el Triage</h2>
            </div>
        </div>
        <div>
                <p>El triage es un sistema de clasificación de pacientes que se basa en la gravedad de su estado de salud. Los criterios de evaluación para el triage son una serie de indicadores que permiten determinar la prioridad de atención de los pacientes en función de su estado de salud. Estos criterios se utilizan para asignar a los pacientes a una categoría de prioridad y garantizar que los pacientes más graves reciban atención médica de forma inmediata.</p>
                <br>
                <p>Los criterios de evaluación para el triage se basan en la evaluación de diferentes parámetros, como la frecuencia cardíaca, la presión arterial, la temperatura corporal, la saturación de oxígeno, la frecuencia respiratoria, el nivel de conciencia, el dolor, entre otros. Estos criterios permiten identificar a los pacientes que requieren atención médica urgente y garantizar que reciban la atención necesaria en el menor tiempo posible.</p>
        </div>
    </div>
</section>
<!--botones-->
<div class="columns is-centered">
    <div class="column is-8"> <!-- Utiliza una columna centrada con ancho 70% (8/12) -->
        <a href="index.php?vista=triage" class="button subtitle is-rounded is-large is-fullwidth has-background-danger-dark has-text-light">
            <span class="icon is-small is-left mr-6">
                <i class="fas fa-play"></i> <!-- Icono de play -->
            </span>
            <span>RACE (Evaluación de emergencias médicas)</span>
        </a>
    </div>
</div>
<div class="columns is-centered">
    <div class="column is-8"> <!-- Utiliza una columna centrada con ancho 70% (8/12) -->
        <a href="#" class="button subtitle is-rounded is-large is-fullwidth has-background-danger-dark has-text-light">
            <span class="icon is-small is-left mr-6">
                <i class="fas fa-play"></i> <!-- Icono de play -->
            </span>
            <span>C-STAT (Dolor torácico y síntomas cardíacos)</span>
        </a>
    </div>
</div>
<div class="columns is-centered">
    <div class="column is-8"> <!-- Utiliza una columna centrada con ancho 70% (8/12) -->
        <a href="#" class="button subtitle is-rounded is-large is-fullwidth has-background-danger-dark has-text-light">
            <span class="icon is-small is-left mr-6">
                <i class="fas fa-play"></i> <!-- Icono de play -->
            </span>
            <span class="mr-2">FAST-ED (Accidente cerebrovascular)</span>
        </a>
    </div>
</div>
<div class="columns is-centered">
    <div class="column is-8"> <!-- Utiliza una columna centrada con ancho 70% (8/12) -->
        <a href="#" class="button subtitle is-rounded is-large is-fullwidth has-background-danger-dark has-text-light">
            <span class="icon is-small is-left mr-6">
                <i class="fas fa-play"></i> <!-- Icono de play -->
            </span>
            <span>HEART Score (Dolor torácico y síntomas cardíacos):</span>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona el botón por su id
        var btnComenzar = document.getElementById('btn-comenzar');

        // Agrega un event listener para el clic en el botón
        btnComenzar.addEventListener('click', function() {
            // Obtiene la posición (offsetTop) de la sección con id "criterios"
            var sectionCriterios = document.getElementById('criterios');
            var sectionCriteriosOffsetTop = sectionCriterios.offsetTop;

            // Realiza un desplazamiento suave hasta la posición de la sección
            window.scrollTo({
                top: sectionCriteriosOffsetTop,
                behavior: 'smooth'  // Desplazamiento suave
            });
        });
    });
</script>
