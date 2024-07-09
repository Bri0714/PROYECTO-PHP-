<div class="main-container">
    <form action="" method="POST" autocomplete="off" class="box login">
        <h2 class="title is-5 has-text-centered"> Sign in to SaludCheck</h2>
        
        <div class="columns is-centered">
            <figure class="image is-128x128 ">
                <img class="" src="./img/logo2.png" />
            </figure>
        </div>

        <div class="field">
            <label for="usuario" class="label">Usuario</label>
            <div class="control">
                <input class="input" type="text" placeholder="Email" id="usuario" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
            </div>
        </div>

        <div class="field">
            <label for="contraseña" class="label">Contraseña</label>
            <div class="control">
                <input class="input" type="password" placeholder="Password" id="contrasena" name="login_contraseña" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
            </div>
        </div>

        <div class="buttons is-centered p-4">
            <p class="control ">
                <button class="button has-text-light">
                    Login
                </button>
            </p>
        </div>
        <?php

        # inicio de sesion se verifica si se han llenado los dos campos requeridos 

        if(isset($_POST["login_usuario"]) && isset($_POST["login_contraseña"])){

            require_once "./php-BD/main.php";
            require_once "./php-BD/iniciar_sesion.php";
        }
        ?>
    </form>
</div>

<style>
    .box{
        background-color: #33000A;
        color: white;
    }
    .label{
        color: white;
    }
    .title{
        color: white;
    }
    .button{
        background-color: #6B0015;
    }
</style>

