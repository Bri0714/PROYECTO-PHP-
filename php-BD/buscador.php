<?php 

$modulo_buscador = limpiar_cadena($_POST['modulo_buscador']);

$modulos=["usuario","eps","hospitales"];

#la funcion inarray lo que hace 
#es buscar un valor en un array
#si lo encuentra devuelve true
#si no lo encuentra devuelve false
#se le pasan dos parametrosj
#el primero es el valor que se va a buscar
#el segundo es el array en el que se va a buscar
if(in_array($modulo_buscador,$modulos)){

    $modulos_url =[

        "usuario"=>"user_search",
        "eps"=>"eps_search",
        "hospitales"=>"hospitales_search",
    ];

    $modulos_url = $modulos_url[$modulo_buscador];
    $modulo_buscador = "busqueda_".$modulo_buscador;

    //iniciar busqueda 
    if(isset($_POST['txt_buscador'])){  
        $txt = limpiar_cadena($_POST['txt_buscador']);

        if($txt == ""){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has introducido criterios de busqueda
                </div>
            ';
        }else{
            if(validar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}',$txt)){
                
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El criterio de busqueda no coincide con el formato solicitado
                    </div>
                ';
            }else{
                $_SESSION[$modulo_buscador] = $txt;
                header("Location: index.php?vista=".$modulos_url,true,303);
                exit();
            }
        }
    }

    if(isset($_POST['eliminar_buscador'])){
        unset($_SESSION[$modulo_buscador]); # el metodo unset sirve para eliminar una variable de la superglobal
        header("Location: index.php?vista=".$modulos_url,true,303);
        exit();
    }

}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El modulo que intentas buscar no existe
        </div>
    ';

}