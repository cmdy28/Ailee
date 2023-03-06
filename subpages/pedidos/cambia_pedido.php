<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../class/pedidos/pedido.class.php';

$pedidos = new Pedido();

$idPedido = '';
if(isset($_REQUEST['idPedido'])){
    $idPedido=$_REQUEST{'idPedido'};
}

$cambia = $pedidos->actualizaPedidoEstado($gbd, $idPedido, 7);
if($cambia){
    echo 'Se cambio el estado del pedido';
}else{
    echo 'No se puedo cambiar';
}



?>