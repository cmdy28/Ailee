<style>
     .bg-nav-top {
        background-color: #121B26;
    }

    .bg-nav-bottom {
        background-color: #F2F2F2;
    }

    .text-ailee {
        font-size: 18px;
    }

    .navbar {
        height: 45px;
    }

    .navbar-brand {
        padding-top: none;
        padding-bottom: none;
    }

    .info {
        float: left;
    }

    /*ICONS*/
    .fa-user-circle {
        font-size: 25px;
    }

    .fa-question-circle {
        font-size: 25px;
        margin-right: 40px;
        padding: 5px;
    }

    .hora{
        text-decoration:none;
        color:#fff;
        font-size:20px;
    }
    .sup{
        font-size:11px;
        color:#82BF26;
    }
</style>
<nav class="navbar bg-nav-top">
    <div class="container-fluid">
        <a class="nav-link text-light" href="#">
            <img src="./assets/img/ailee-green-bg-dark-t-logo.png" alt="Logo" height="30" class="">
            <span class="text-ailee">AILEE <sup class="sup">00000</sup></span>
        </a>
        <div>
            <a class="hora">00:00:00</a>
        </div>
        <div>
            <a class="nav-link text-light info" href="#">
                <i class="fas fa-question-circle"></i>
            </a>
            <div class="dropdown">
                <button class="dropbtn">User <i class="fas fa-user-circle"></i></button>
                <div class="dropdown-content">
                    <a href="?modulo=perfil_usuario">Perfil</a>
                    <a href="?modulo=general">Configuración</a>
                    <a href="#">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</nav>