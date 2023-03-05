<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../class/pedidos/factura.class.php';
include '../../class/pedidos/pedido.class.php';

$pedidos = new Pedido();
$facturas = new Factura();

$pedido='';
$subtotal='';
$iva='';
$total='';
$cliente ='';
if (isset($_REQUEST['idPedido'])) {
    $pedido = $_REQUEST['idPedido'];
}
if(isset($_REQUEST['subtotal'])){
    $subtotal = $_REQUEST['subtotal'];
    $subtotal =ltrim($subtotal, '$');
}
if(isset($_REQUEST['iva'])){
    $iva = $_REQUEST['iva'];
    $iva =ltrim($iva, '$');
}
if(isset($_REQUEST['total'])){
    $total = $_REQUEST['total'];
    $total =ltrim($total, '$');
}
if(isset($_REQUEST['cliente'])){
    $cliente = $_REQUEST['cliente'];
}else{
    $cliente = 2;
}
if(isset($_REQUEST['opc'])){
    $opc = $_REQUEST['opc'];
}
if(isset($_REQUEST['mesa'])){
    $mesa = $_REQUEST['mesa'];
}

echo 'El cliente: '.$cliente;
$guarda = $facturas->guardarFactura($gbd, $cliente, $subtotal, $iva, $total);
var_dump($guarda);
$idFactura = $guarda['id'];

echo 'Factura: '.$idFactura;
$actualiza=$pedidos->actualizaFacturaPedido($gbd, $pedido, $idFactura);

if($actualiza){
    echo 'Se agregó la factura al detalle_pedido';
}

if($opc == 1){
$agrega=$pedidos->agregaMesaPedido($gbd, $pedido, $mesa);
var_dump($agrega);
//estados 1= disponible y 2=ocupado
$actualiza_mesa=$pedidos->actualizaMesa($gbd, $mesa, 2 );
var_dump($actualiza_mesa);
}



?>