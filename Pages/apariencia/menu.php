<style>
    .bg-nav-bottom {
        background-color: #F2F2F2;
        box-shadow: 0px 15px 10px -20px #111;
    }
    .nav-item {
        height: auto;
        font-size: 20px;
    }

    .nav-item:hover {
        background-color: #82BF26;
        color:#fff;
    }

    .active {
        background-color: #A8D95F;
    }

    .navbar-toggler {
        border: none;
    }
    .dropbtn:hover{
        color:#fff;
    }
</style>
<nav class="navbar navbar-expand-lg bg-nav-bottom">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item ">
                    <a type="button" href="?modulo=start" class="dropbtn nav-link-down" style="text-decoration:none;" >Home</a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropbtn nav-link-down">Punto de Venta</button>
                        <div class="dropdown-content">
                            <a href="?modulo=menu" class="text-content">Menú POS</a>
                            <a href="?modulo=mesas" class="text-content">Mesas</a>
                            <a href="?modulo=historial" class="text-content">Historial</a>
                            <a href="?modulo=clientes" class="text-content">Clientes</a>
                            <a href="?modulo=comandera" class="text-content">Comandera</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropbtn nav-link-down">Provisión</button>
                        <div class="dropdown-content">
                            <a href="?modulo=productos" class="text-content">Productos</a>
                            <a href="?modulo=compras" class="text-content">Compras</a>
                            <a href="?modulo=proveedores" class="text-content">Proveedores</a>
                            <a href="?modulo=procesamiento" class="text-content">Procesamiento</a>
                            <a href="?modulo=fisico" class="text-content">Físico¿?</a>
                            <a href="?modulo=cardex" class="text-content">Cardex¿?</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropbtn nav-link-down">Empleados</button>
                        <div class="dropdown-content">
                            <a href="?modulo=empleados" class="text-content">Lista</a>
                            <a href="?modulo=registro_asistencia" class="text-content">Registro de Asistencia</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropbtn nav-link-down">Resultados</button>
                        <div class="dropdown-content">
                            <a href="?modulo=start" class="text-content">Dashboard</a>
                            <a href="?modulo=reportes" class="text-content">Reportes</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropbtn nav-link-down">Configuración</button>
                        <div class="dropdown-content">
                            <a href="?modulo=general" class="text-content">General</a>
                            <a href="?modulo=usuarios" class="text-content">Administrar Usuarios</a>
                            <a href="?modulo=conf_menu" class="text-content">Conf. Menú</a>
                            <a href="?modulo=conf_mesas" class="text-content">Conf. Mesas</a>
                            <a href="?modulo=conf_comandera" class="text-content">Conf. Comandera Visual</a>
                        </div>
                    </div>
                </li>
                </li>
            </ul>

        </div>
    </div>
</nav>

