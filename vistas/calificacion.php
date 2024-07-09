<?php
// Obtener las respuestas del cuestionario del POST
$answers = json_decode($_POST['answers'], true);

// Función para calcular la calificación de triaje
function calcularCalificacionTriaje($respuestas)
{
    // Lógica para evaluar las respuestas y asignar la calificación
    if (
        $respuestas['debilidad_facial'] === 'si' &&
        $respuestas['dificultad_brazos'] === 'si' &&
        $respuestas['dificultad_habla'] === 'si' &&
        $respuestas['tiempo_sintomas'] === 'menos_3_horas'
    ) {
        return 1; // Triage I
    } elseif (
        $respuestas['freq_respiratoria'] === 'elevada' ||
        $respuestas['freq_respiratoria'] === 'baja' ||
        $respuestas['alerta_orientado'] === 'no' ||
        $respuestas['circulacion_deficiente'] === 'si'
    ) {
        return 2; // Triage II
    } elseif ($respuestas['alerta_orientado'] === 'parcial') {
        return 3; // Triage III
    } elseif ($respuestas['problema_exposicion'] === 'si') {
        return 4; // Triage IV
    } else {
        return 5; // Triage V
    }
}

// Calcular la calificación de triaje
$calificacion = calcularCalificacionTriaje($answers);

// Mostrar el contenido correspondiente según la calificación
switch ($calificacion) {
    case 1:
        $titulo = 'Triage I';
        $descripcion = 'Requiere atención inmediata. La condición clínica del paciente representa un riesgo vital y necesita maniobras de reanimación...';
        $boton = '<button class="is-rounded">Solicitar Atención Inmediata</button>';
        break;
    case 2:
        $titulo = 'Triage II';
        $descripcion = 'La condición clínica del paciente puede evolucionar hacia un rápido deterioro o a su muerte...';
        $boton = '<button class="is-rounded">Atención en los próximos 30 minutos</button>';
        break;
    case 3:
        $titulo = 'Triage III';
        $descripcion = 'La condición clínica del paciente requiere de medidas diagnósticas y terapéuticas en urgencias...';
        $boton = '<button class="is-rounded">Atención en las próximas horas</button>';
        break;
    case 4:
        $titulo = 'Triage IV';
        $descripcion = 'El paciente presenta condiciones médicas que no comprometen su estado general, ni representan un riesgo evidente para la vida o pérdida de miembro u órgano...';
        $boton = '<button class="is-rounded">Atención en las próximas horas</button>';
        break;
    case 5:
        $titulo = 'Triage V';
        $descripcion = 'El paciente presenta una condición clínica relacionada con problemas agudos o crónicos sin evidencia de deterioro que comprometa el estado general de paciente y no representa un riesgo evidente para la vida o la funcionalidad de miembro u órgano.';
        $boton = '<button class="is-rounded">Atención en las próximas horas</button>';
        break;
    default:
        $titulo = 'Calificación de triaje no válida';
        $descripcion = '';
        $boton = '';
}
?>
<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .box {
        max-width: 500px;
        width: 100%;
        padding: 4rem;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        /* Añadido */
        flex-direction: column;
        /* Añadido */
        align-items: center;
        /* Añadido */
    }

    .circle {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        font-size: 3rem;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    .button {
        font-family: 'Poppins', sans-serif;
    }

    /* Estilo para el botón */
    .buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .buttons button {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        padding: 10px 20px;
        border: none;
        border-radius: 25px;
        color: white;
        background-color: <?php echo $botoncolor; ?>;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .buttons button:hover {
        background-color: darken(<?php echo $botoncolor; ?>, 10%);
    }
</style>
</style>

<div class="container">
    <div class="box">
        <?php
        $circleColor = 'has-background-danger';
        switch ($calificacion) {
            case 1:
            case 2:
                $circleColor = 'has-background-danger';
                $botoncolor = 'has-background-danger';
                break;
            case 3:
            case 4:
                $circleColor = 'has-background-warning';
                $botoncolor = 'has-background-warning';
                break;
            case 5:
                $circleColor = 'has-background-success';
                $botoncolor = 'has-background-success';
                break;
        }
        ?>
        <div class="circle <?php echo $circleColor; ?> has-text-white"><?php echo $calificacion; ?></div>
        <p class="description mt-2 mb-2 has-text-centered has-text-weight-normal"><?php echo $descripcion; ?></p>
        <div class="buttons <?php echo $botoncolor; ?> ">
            <?php echo $boton  ?>
        </div>
        <div class="buttons is-centered mt-4">
            <a href="index.php?vista=triage" class="button has-background-danger-dark has-text-white is-rounded">Volver al cuestionario</a>
            <a href="index.php?vista=maps_hospitales" class="button has-background-danger-dark has-text-white is-rounded">Centros médicos más cercanos</a>
        </div>
    </div>
</div>