<div class="container is-fluid mb-6">
    <h1 class="title">Pacientes</h1>
    <h2 class="subtitle">Lista de pacientes</h2>
</div>

<div class="body container pb-6 pt-6">
    <?php 

    require_once "./php-BD/main.php";

    //eliminar usuario 

    if(isset($_GET['user_id_del'])){
        require_once './php-BD/usuario_eliminar.php';
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
    $url= "index.php?vista=user_list&page=";
    $registros = 15;
    $busqueda = "";

    require_once "./php-BD/usuario_lista.php";
    
    ?>
</div>

<style>
    .body {
        position: relative;
        min-height: 70vh;
    }
</style>
