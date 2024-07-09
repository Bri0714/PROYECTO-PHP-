<?php
// Incluir el archivo de conexión a la base de datos
require_once("./php-BD/main.php");

try {
    // Obtener la conexión PDO
    $pdo = conexion();

    // Consulta SQL para obtener los datos
    $query = "SELECT m.latitud, m.longitud, h.nombre_hospital, h.descripcion_hospital FROM mapa m JOIN hospital h ON m.id_hospital = h.id_hospital";

    // Ejecutar la consulta SQL
    $stmt = $pdo->query($query);

    // Comprobar si la consulta fue exitosa
    if (!$stmt) {
        throw new Exception('Consulta inválida: ' . $pdo->errorInfo()[2]);
    }

    // Establecer el encabezado para indicar que se devolverá HTML
    header("Content-type: text/html; charset=UTF-8");

    // Iniciar el contenido HTML
    echo '<!DOCTYPE html>';
    echo '<html lang="es">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>Mapa de Hospitales</title>';
    echo '<style>';
    echo '.map-container-2 {
        overflow: hidden;
        padding-bottom: 56.25%;
        position: relative;
        height: 0;
    }';
    echo '.map-container-2 iframe {
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        position: absolute;
    }';
    echo '</style>';
    echo '</head>';
    echo '<body>';

    echo '<div class="container is-fluid p-6">';
    echo '<h1 class="title ">Mapa</h1>';
    echo '<h2 class="subtitle">Ubicación de los Hospitales Cercanos</h2>';
    echo '</div>';

    echo '<div class="container p-6">';
    echo '<div class="row">';
    echo '<div class="col-md-8">';
    echo '<div id="map-container-google-2" class="z-depth-1-half map-container" style="height: 600px;"></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    // Crear un array JavaScript con los datos
    $datos = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Convertir latitud y longitud a números
        $lat = floatval($row['latitud']);
        $lng = floatval($row['longitud']);
    
        $datos[] = array(
            'lat' => $lat,
            'lng' => $lng,
            'nombre' => $row['nombre_hospital'],
            'descripcion' => $row['descripcion_hospital']
        );
    }

    // Imprimir el array JavaScript en el HTML
    echo "<script>var datos = " . json_encode($datos) . ";</script>";
?>

    <script>
        console.log("Datos recibidos:", datos);

        function initMap() {
            console.log("Función initMap() ejecutada");

            var map = new google.maps.Map(document.getElementById('map-container-google-2'), {
                center: {
                    lat: 4.60971,
                    lng: -74.08175
                },
                zoom: 7
            });

            // Agregar los marcadores al mapa
            datos.forEach(function(dato) {
                console.log("Creando marcador para:", dato);
                var marker = new google.maps.Marker({
                    position: {
                        lat: dato.lat,
                        lng: dato.lng
                    },
                    map: map,
                    title: dato.nombre
                });

                var infoWindow = new google.maps.InfoWindow({
                    content: '<h3>' + dato.nombre + '</h3><p>' + dato.descripcion + '</p>'
                });

                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXNvVcFIicTG9YetWIGax7hH5GY5iGUcU&callback=initMap"></script>

<?php
    echo '</body>';
    echo '</html>';
} catch (PDOException $e) {
    die('Error en la conexión: ' . $e->getMessage());
} catch (Exception $e) {
    die('Error en la consulta: ' . $e->getMessage());
}
?>