<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
if(isset($_REQUEST['categoria_new'])){
    $categoria_new = $_REQUEST['categoria_new'];
    echo $categoria_new;
    echo '<script>
        window.location="http://localhost/Ailee/pages/inicio.php?modulo=nuevoproducto";
    </script>
    ';
}


?>