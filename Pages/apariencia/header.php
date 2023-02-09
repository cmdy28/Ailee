<?php 
$id = $_SESSION['id'];
if(strlen($id) <= 3){
    $id="00".$id;
}
?>
<style>
    .bg-nav-top {
        background-color: #121B26;
        padding: 0px;
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
        margin-left: 10px;
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
    /* The container <div> - needed to position the dropdown content */
    .dropdown-u {
        position: relative;
        display: inline-block;
    }
    /* Dropdown Content (Hidden by Default) */
    .dropdown-content-u {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f1f1f1;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }
    /* Links inside the dropdown */
    .dropdown-content-u a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content-u a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu on hover */
    .dropdown-u:hover .dropdown-content-u {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown-u:hover .dropbtn {
        background-color: transparent;
    }
</style>
<nav class="navbar bg-nav-top">
    <div class="container-fluid">
        <a class="nav-link text-light" href="#">
            <img src="../assets/img/ailee-green-bg-dark-t-logo.png" alt="Logo" height="30" class="">
            <span class="text-ailee">AILEE <sup class="sup"><?php echo $id ?></sup></span>
        </a>
        <div>
            <a class="hora">00:00:00</a>
        </div>
        <div>
            <a class="nav-link text-light info" href="#">
                <i class="fas fa-question-circle"></i>
            </a>
            <div class="dropdown-u">
                <button class="dropbtn" style="color:#fff"><?php echo $_SESSION['empresa'] ?><i class="fas fa-user-circle"></i></button>
                <div class="dropdown-content-u" >
                    <a href="?modulo=perfil_usuario">Perfil</a>
                    <a href="?modulo=general">Configuración</a>
                    <a href="login.php">Cerrar Sesión 
                    <?php
					session_abort();
					?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>