<?php
	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    error_reporting(0);
	date_default_timezone_set('America/Guayaquil');
	class InitTicket{
		public $route;  
		public $subpagePath;
		public $title;
		//Lista las subpaginas
		public $pages = array(
			'start' => array('path' => './subpages/resultados/index.php','title' => 'Ailee - Gestiona tu Restaurante !'),
            'clientes' => array('path' => './subpages/punto_venta/clientes/index.php','title' => 'Home'),
			'menu' => array('path' => './subpages/punto_venta/pedidos/index.php','title' => 'Menú POS'),
			'mesas' => array('path' => './subpages/punto_venta/pedidos/mesas.php','title' => 'Mesas'),
			'historial' => array('path' => './subpages/punto_venta/pedidos/historial.php','title' => 'Historial Pedidos'),
			'comandera' => array('path' => './subpages/punto_venta/pedidos/comandera.php','title' => 'Comandera Visual'),
			'productos' => array('path' => './subpages/provision/productos/index.php','title' => 'Productos'),
			'compras' => array('path' => './subpages/provision/compras.php','title' => 'Compras'),
			'proveedores' => array('path' => './subpages/provision/proveedores/index.php','title' => 'Proveedores'),
			'procesamiento' => array('path' => './subpages/provision/procesamiento.php','title' => 'Procesamiento'),
			'fisico' => array('path' => './subpages/provision/fisico.php','title' => 'Físico'),
			'cardex' => array('path' => './subpages/provision/cardex.php','title' => 'Cardex'),
			'empleados' => array('path' => './subpages/empleados/index.php','title' => 'Lista de Empleados'),
			'registro_asistencia' => array('path' => './subpages/empleados/registro_asistencia.php','title' => 'Registro de Asistencia'),
			'reportes' => array('path' => './subpages/resultados/reportes.php','title' => 'Reportes'),
			'general' => array('path' => './subpages/configuracion/general.php','title' => 'General'),
			'usuarios' => array('path' => './subpages/configuracion/usuarios.php','title' => 'Usuarios'),
			'conf_menu' => array('path' => './subpages/configuracion/configuracion_menu.php','title' => 'Configuración Menú'),
			'conf_mesas' => array('path' => './subpages/configuracion/configuracion_mesas.php','title' => 'Configuración Mesas'),
			'conf_comandera' => array('path' => './subpages/configuracion/configuracion_comandera.php','title' => 'Configuración Comandera Visual '),
			'perfil_usuario' => array('path' => './subpages/configuracion/perfil-usuario.php','title' => 'Perfil del Usuario'),
			);
		
		public function __construct(){
			$this -> CheckIfPageRequestIsLegal();
		}
		
		public function CheckIfPageRequestIsLegal(){
			// if(isset($_SESSION['autentica']) &&  $_SESSION['autentica'] == 'acceso_correcto'){
				
			// }else{
				// $request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'login';
			// }
		
			$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'start';
			
			if(array_key_exists($request,$this -> pages)){
				$this -> subpagePath = $this -> pages[$request]['path'];
				$this -> title = $this -> pages[$request]['title'];
			}else{
				$this -> subpagePath = 'subpages/404.php';
			}
		}
	}
?>