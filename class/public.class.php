<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    error_reporting(0);
    date_default_timezone_set('America/Guayaquil');
    class InitTicket
    {
        public $route;
        public $subpagePath;
        public $title;
        //Lista las subpaginas
        public $pages = array(
            'start' => array('path' => '../subpages/resultados/index.php','title' => 'Ailee - Dashboard'),
            'clientes' => array('path' => '../subpages/clientes/index.php','title' => 'Clientes'),
            'nuevocliente' => array('path' => '../subpages/clientes/new.php','title' => 'Agregar / Editar Cliente'),
            'menu' => array('path' => '../subpages/pedidos/index.php','title' => 'Menú POS'),
            'mesas' => array('path' => '../subpages/pedidos/mesas.php','title' => 'Mesas'),
            'historial' => array('path' => '../subpages/pedidos/historial.php','title' => 'Historial Pedidos'),
            'detallePedido' => array('path' => '../subpages/pedidos/detalle_pedido.php','title' => 'Detalle de Pedido'),
            'comandera' => array('path' => '../subpages/pedidos/comandera.php','title' => 'Comandera - Pedidos'),
            'productos' => array('path' => '../subpages/productos/index.php','title' => 'Productos'),
            'nuevoproducto' => array('path' => '../subpages/productos/new.php','title' => 'Agregar / Editar Producto'),
            'compras' => array('path' => '../subpages/provision/compras.php','title' => 'Compras'),
            'proveedores' => array('path' => '../subpages/proveedores/index.php','title' => 'Proveedores'),
            'nuevoproveedor' => array('path' => '../subpages/proveedores/new.php','title' => 'Agregar / Editar Proveedor'),
            'procesamiento' => array('path' => '../subpages/provision/procesamiento.php','title' => 'Procesamiento'),
            'fisico' => array('path' => '../subpages/provision/fisico.php','title' => 'Físico'),
            'cardex' => array('path' => '../subpages/provision/cardex.php','title' => 'Cardex'),
            'empleados' => array('path' => '../subpages/empleados/index.php','title' => 'Lista de Empleados'),
            'nuevoempleado' => array('path' => '../subpages/empleados/new.php','title' => 'Agregar / Editar Empleado'),
            'registro_asistencia' => array('path' => '../subpages/empleados/registro_asistencia.php','title' => 'Registro de Asistencia'),
            'reportes' => array('path' => '../subpages/resultados/reportes.php','title' => 'Reportes'),
            'general' => array('path' => '../subpages/configuracion/general.php','title' => 'General'),
            'usuarios' => array('path' => '../subpages/configuracion/usuarios.php','title' => 'Usuarios'),
            'conf_menu' => array('path' => '../subpages/configuracion/configuracion_menu.php','title' => 'Configuración Menú'),
            'conf_mesas' => array('path' => '../subpages/configuracion/configuracion_mesas.php','title' => 'Configuración Mesas'),
            'conf_comandera' => array('path' => '../subpages/configuracion/configuracion_comandera.php','title' => 'Configuración Comandera Visual '),
            'perfil_usuario' => array('path' => '../subpages/configuracion/perfil-usuario.php','title' => 'Perfil del Usuario'),
            );

        public function __construct()
        {
            $this -> CheckIfPageRequestIsLegal();
        }

        public function CheckIfPageRequestIsLegal()
        {
            // if(isset($_SESSION['autentica']) &&  $_SESSION['autentica'] == 'acceso_correcto'){

            // }else{
            // $request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'login';
            // }

            $request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'menu';

            if (array_key_exists($request, $this -> pages)) {
                $this -> subpagePath = $this -> pages[$request]['path'];
                $this -> title = $this -> pages[$request]['title'];
            } else {
                $this -> subpagePath = 'subpages/404.php';
            }
        }
    }
