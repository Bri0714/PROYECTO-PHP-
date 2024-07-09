<?php

$inicio = ($pagina = 1) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

if (isset($busqueda) && $busqueda != "") {
    // Consulta para obtener datos filtrados
    $consulta_datos = "SELECT u.*, e.eps_nombre 
                        FROM usuario u 
                        JOIN eps e ON u.eps_id = e.eps_id 
                        WHERE (u.Usuario_id != '" . $_SESSION["id"] . "' 
                                AND (u.Usuario_nombre LIKE '%$busqueda%' 
                                    OR u.Usuario_apellido LIKE '%$busqueda%' 
                                    OR u.Usuario_usuario LIKE '%$busqueda%' 
                                    OR u.Usuario_email LIKE '%$busqueda%' 
                                    OR e.eps_nombre LIKE '%$busqueda%')) 
                        ORDER BY u.Usuario_nombre ASC 
                        LIMIT $inicio, $registros";

    // Consulta para obtener el total de registros filtrados
    $consulta_total = "SELECT COUNT(u.Usuario_id) 
                        FROM usuario u 
                        JOIN eps e ON u.eps_id = e.eps_id 
                        WHERE (u.Usuario_id != '" . $_SESSION["id"] . "' 
                                AND (u.Usuario_nombre LIKE '%$busqueda%' 
                                    OR u.Usuario_apellido LIKE '%$busqueda%' 
                                    OR u.Usuario_usuario LIKE '%$busqueda%' 
                                    OR u.Usuario_email LIKE '%$busqueda%' 
                                    OR e.eps_nombre LIKE '%$busqueda%'))";
} else {
    // Consulta para obtener datos sin filtro
    $consulta_datos = "SELECT u.*, e.eps_nombre 
                        FROM usuario u 
                        JOIN eps e ON u.eps_id = e.eps_id 
                        WHERE Usuario_id != '" . $_SESSION["id"] . "' 
                        ORDER BY Usuario_nombre ASC 
                        LIMIT $inicio, $registros";

    // Consulta para obtener el total de registros sin filtro
    $consulta_total = "SELECT COUNT(Usuario_id) 
                        FROM usuario 
                        WHERE Usuario_id != '" . $_SESSION["id"] . "'";
}

# conexion a la base de datos 

$conexion = conexion();

# consulta a la base de datos utilizando la variable $consulta datos que tiene 
# la consulta de los datos a mostrar en la tabla
$datos = conexion()->query($consulta_datos);

# Luego se utiliza felchall que se hace para 
# devolver un array que contiene todas las filas del conjunto de resultados

# se utiliza el fetchall para obtener todos los datos de la consulta
# y se almacenan en la variable $datos

$datos = $datos->fetchAll();

# luego con la consulta de count de id 
# se obtiene el total de registros de la tabla

$total = conexion()->query($consulta_total);
$total = (int) $total->fetchColumn();
#print_r($datos);

$Npaginas = ceil($total / $registros);

# el metodo ceil 
# redondea fracciones hacia arriba

$tabla .= "
    <div class='table-container'>
        <table class='table is-bordered is-striped is-narrow is-hoverable is-fullwidth'>
            <thead>
                <tr>
                    <th class='has-text-centered'>id</th>
                    <th class='has-text-centered'>Nombre</th>
                    <th class='has-text-centered'>Apellido</th>
                    <th class='has-text-centered'>Usuario</th>
                    <th class='has-text-centered'>Email</th>
                    <th class='has-text-centered'>EPS</th>
                    <th class='has-text-centered' colspan='2'>Opciones</th>
                </tr>
            </thead>
            <tbody>
";

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;

    foreach ($datos as $rows) {
        $tabla .= '
            
        <tr class="has-text-centered">
            <td>' . $contador . '</td>
            <td>' . $rows["Usuario_nombre"] . '</td>
            <td>' . $rows["Usuario_apellido"] . '</td>
            <td>' . $rows["Usuario_usuario"] . '</td>
            <td>' . $rows["Usuario_email"] . '</td>
            <td>' . $rows["eps_nombre"] . '</td>
            
            <td>
                <a href="index.php?vista=user_update&user_id_up=' . $rows['Usuario_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
            </td>
            <td>
                <a href="'.$url.$pagina.'&user_id_del='.$rows['Usuario_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
            </td>
        </tr>
        ';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($total >= 1) {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="7">
                    <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}

$tabla .= "

            </tbody>
        </table>
    </div>
";

if ($total >= 1 && $pagina <= $Npaginas) {
    $tabla .= '
    <p class="has-text-right">Mostrando usuarios <strong>1</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>
    ';
}

$conexion = null;

echo $tabla;

if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
