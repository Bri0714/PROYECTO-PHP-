<div class="container is-fluid mb-6">
    <h1 class="title">Hospitales</h1>
    <h2 class="subtitle">Lista de Hospitales</h2>
</div>

<div class="body container pb-6 pt-6">
    <?php 

    require_once "./php-BD/main.php";

    //eliminar usuario 

    if(isset($_GET['hospital_id_del'])){
        require_once './php-BD/hospital_eliminar.php';
    }

    if(!isset($_GET["page"])){
        $pagina=1;
    }else{
        $pagina = (int) $_GET["page"];
        if($pagina <= 1){
            $pagina = 1;
        }
    }

    $pagina = limpiar_cadena($pagina);
    $url= "index.php?vista=hospitales_list&page=";
    $registros = 15;
    $busqueda = "";

    require_once "./php-BD/hospital_lista.php";
    
    ?>
</div>

<style>
    .body {
        position: relative;
        min-height: 70vh;
    }
</style>
