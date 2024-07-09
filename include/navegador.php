<!-- Lo primero que haremos en la creación del proyecto sera instalar el framework Bulma para darle un diseño más atractivo a nuestro proyecto -->

<nav class="navbar has-background-danger-dark is-danger" role="navigation" aria-label="main navigation">
    <div class="navbar-brand ">
        <a class="navbar-item has-text-light" href="index.php?vista=Home">
            <img src="img/logo2.png">
            Saludcheck
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <div class="navbar-item has-dropdown p-4 is-hoverable ">
                <a class="navbar-link has-background-white has-text-danger-dark button is-primary is-rounded">
                    Pacientes
                </a>

                <div class="navbar-dropdown">

                    <a class="navbar-item " href="index.php?vista=user_new">
                        Nuevo
                    </a>
                    <a class="navbar-item" href="index.php?vista=user_list">
                        Lista
                    </a>
                    <a class="navbar-item" href="index.php?vista=user_search">
                        Buscar
                    </a>
                </div>
            </div>

            <div class="navbar-item has-dropdown p-4 is-hoverable">
                <a class="navbar-link has-background-danger-dark has-text-light button is-rounded">
                    Centros Hospitalarios
                </a>

                <div class="navbar-dropdown">

                    <a class="navbar-item" href="index.php?vista=hospitales_new">
                        Nuevo
                    </a>
                    <a class="navbar-item" href="index.php?vista=hospitales_list">
                        Lista
                    </a>
                    <a class="navbar-item" href="index.php?vista=hospitales_search">
                        Buscar
                    </a>
                </div>
            </div>

        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href='index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id'] ?>' class="button is-light is-rounded has-text-danger-dark">
                        <strong>Mi Cuenta</strong>
                    </a>
                    <a href="index.php?vista=logout" class="button is-primary is-rounded has-text-light is-danger is-dark">
                        Salir
                    </a>
                </div>
            </div>
        </div>

    </div>
</nav>