<?php

# archivo donde este la concexion a la base de datos , funciones para evitar la inyeccion sql etc 

# como crar la concexion a una base de datos en php mysql con la extension PDO 

#$pdo = new PDO('mysql:host=localhost;dbname=saludcheck','root',''); # esto es una nueva instancia para conectarse a la base de datos 
# Conexion a la base de datos 

function conexion()
{
	$pdo = new PDO('mysql:host=localhost;dbname=saludcheck', 'root', '');
	return $pdo;
}

# Verificar datos 
# Funcion para validar datos con expresiones regulares
# utlizamos la función o metodo preg_match() para validar datos con expresiones regulares lo que hace este metodo es recibir dos parametros el primero es la expresion regular y el segundo es el dato que queremos validar si el patron de la expresion regular se cumple con el dato que queremos validar nos devolvera un true si no se cumple nos devolvera un false

# preg_match se usa para 
# validar datos con expresiones regulares y su funcionamiennto es 
# preg_match("/^".$filtro."$/",$cadena) donde el primer argumento es la expresion regular que queremos validar y el segundo argumento es el dato que queremos validar
# devulve true o false dependiendo si
# el patron de la expresion regular se cumple con el dato que queremos validar
# true si 
# se cumple y false si no se cumple
function validar_datos($filtro, $cadena)
{
	if (preg_match("/^" . $filtro . "$/", $cadena)) {
		return false;
	} else {
		return true;
	}
}

# Ejemplo de uso de la funcion validar_datos()

$nombre = "Juanito";

if (validar_datos("[a-zA-Z]{6,10}", $nombre)) {
	echo "El nombre no es valido";
};

#   funcion para evitar la Inyección SQL

# se utiliza como filtro de seguridad en el sistema para evitar la inyección sql en la base de datos desde los formularios 
# se utlizan funciones de php como trim() stripslashes() y str_ireplace  para evitar la inyección sql en la base de datos
# trim se utiliza para eliminar los espacios en blanco al principio y al final de una cadena
# stripslashes se utiliza para eliminar las barras invertidas de una cadena como por ejemplo : "Hola \"Mundo\"" se convierte en "Hola Mundo"
# str_ireplac sirve para reemplazr un texto mediante una busqueda como por ejemplo : str_ireplace("mundo","Juan","Hola mundo") se convierte en "Hola Juan" el orden de los argumentos que recibe esta función es el siguiente str_ireplace("busqueda","reemplazo","cadena")

function limpiar_cadena($cadena)
{
	$cadena = trim($cadena);
	$cadena = stripslashes($cadena);
	$cadena = str_ireplace("<script>", "", $cadena);
	$cadena = str_ireplace("</script>", "", $cadena);
	$cadena = str_ireplace("<script src", "", $cadena);
	$cadena = str_ireplace("<script type=", "", $cadena);
	$cadena = str_ireplace("SELECT * FROM", "", $cadena);
	$cadena = str_ireplace("DELETE FROM", "", $cadena);
	$cadena = str_ireplace("INSERT INTO", "", $cadena);
	$cadena = str_ireplace("DROP TABLE", "", $cadena);
	$cadena = str_ireplace("DROP DATABASE", "", $cadena);
	$cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
	$cadena = str_ireplace("SHOW TABLES;", "", $cadena);
	$cadena = str_ireplace("SHOW DATABASES;", "", $cadena);
	$cadena = str_ireplace("<?php", "", $cadena);
	$cadena = str_ireplace("?>", "", $cadena);
	$cadena = str_ireplace("--", "", $cadena);
	$cadena = str_ireplace("^", "", $cadena);
	$cadena = str_ireplace("<", "", $cadena);
	$cadena = str_ireplace("[", "", $cadena);
	$cadena = str_ireplace("]", "", $cadena);
	$cadena = str_ireplace("==", "", $cadena);
	$cadena = str_ireplace(";", "", $cadena);
	$cadena = str_ireplace("::", "", $cadena);
	$cadena = trim($cadena);
	$cadena = stripslashes($cadena);
	return $cadena;
}

# Ejemplo de uso de la funcion limpiar_cadena()

#$texto = "<script>'hola';</script>";
#
#echo limpiar_cadena($texto); # Salida: "alert('hola')
#
#echo "<br>";

# Función php para renombrar fotos

# esta función se utiliza para renombrar las fotos que se suben al servidor para evitar que se repitan los nombres de las fotos y se sobreescriban}

function renombrar_foto($nombre)
{
	$nombre = str_ireplace(" ", "_", $nombre);
	$nombre = str_ireplace(" ", "_", $nombre);
	$nombre = str_ireplace("/", "_", $nombre);
	$nombre = str_ireplace("#", "_", $nombre);
	$nombre = str_ireplace("-", "_", $nombre);
	$nombre = str_ireplace("$", "_", $nombre);
	$nombre = str_ireplace(".", "_", $nombre);
	$nombre = str_ireplace(",", "_", $nombre);
	$nombre = $nombre . "_" . rand(0, 100); # la funcion rand nos devuelve un numero aleatorio entre dos numeros que le pasamos como argumentos un minimo en este caso 0 y un maximo en este caso 100
	return $nombre;
}

# Ejemplo de uso de la funcion renombrar_foto()

#$foto = " play station 4 black/edition ";
#echo renombrar_foto($foto); # Salida: "play_station_4_black_edition_50"


# Funcion para generar paginador de tablas en php 


# Funcion paginador de tablas #
function paginador_tablas($pagina, $Npaginas, $url, $botones)
{
	$tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

	if ($pagina <= 1) {
		$tabla .= '
		<a class="pagination-previous is-disabled" disabled >Anterior</a>
		<ul class="pagination-list">';
	} else {
		$tabla .= '
		<a class="pagination-previous" href="' . $url . ($pagina - 1) . '" >Anterior</a>
		<ul class="pagination-list">
			<li><a class="pagination-link" href="' . $url . '1">1</a></li>
			<li><span class="pagination-ellipsis">&hellip;</span></li>
		';
	}

	$ci = 0;
	for ($i = $pagina; $i <= $Npaginas; $i++) {
		if ($ci >= $botones) {
			break;
		}
		if ($pagina == $i) {
			$tabla .= '<li><a class="pagination-link is-current" href="' . $url . $i . '">' . $i . '</a></li>';
		} else {
			$tabla .= '<li><a class="pagination-link" href="' . $url . $i . '">' . $i . '</a></li>';
		}
		$ci++;
	}

	if ($pagina == $Npaginas) {
		$tabla .= '
		</ul>
		<a class="pagination-next is-disabled" disabled >Siguiente</a>
		';
	} else {
		$tabla .= '
			<li><span class="pagination-ellipsis">&hellip;</span></li>
			<li><a class="pagination-link" href="' . $url . $Npaginas . '">' . $Npaginas . '</a></li>
		</ul>
		<a class="pagination-next" href="' . $url . ($pagina + 1) . '" >Siguiente</a>
		';
	}

	$tabla .= '</nav>
	<style>

    .pagination{
        padding: 40px;
    }
    /* Define el color del elemento activo en la paginación */
    .pagination-link.is-current {
        background-color: rgba(65, 1, 1, 0.955); /* Color azul, puedes usar cualquier color que desees */
        color: white; /* Color del texto en el elemento activo */
    }
    .pagination-next{
        background-color: #6B0015; /* Color azul, puedes usar cualquier color que desees */
        color: white; /* Color del texto en el elemento activo */
    }
    .pagination-previous{
        background-color: #6B0015; /* Color azul, puedes usar cualquier color que desees */
        color: white; /* Color del texto en el elemento activo */
    }
</style>
	';
	return $tabla;
}
