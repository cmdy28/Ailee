<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../class/provision/producto.class.php';
include '../../class/pedidos/pedido.class.php';

$productos = new Producto();
$pedidos = new Pedido();

$cant = '';
$id_categoria = '';
if (isset($_REQUEST['idCategoria'])) {
    $id_categoria = $_REQUEST['idCategoria'];
    $sql = " select nombre from categorias where id=$id_categoria";
    $stmtex3 = $gbd->query($sql);
    $stmtex3->execute();
    $categoria = $stmtex3->fetch(PDO::FETCH_ASSOC);
    $nombre_cate = $categoria['nombre'];

    $sql = " select * from productos where categoria=$id_categoria";
    $stmtex1 = $gbd->query($sql);
    $stmtex1->execute();
    $productos = $stmtex1->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($productos);

    foreach ($productos as $product) {
        $contenido = '<div class="col-md-2 col-product">
        <button class="btn-product" onclick="agregarProducto('.$product['id'].');">
        <div class="container-producto" style="background-color:'.$product['color'].'">
            <span class="text-producto">'.$product['nombre'].'</span>
            <br>
            <span class="text-producto-precio">$'.$product['precio_sin_iva'].'</span>
        </div>
        </button>
        </div>';
        echo $contenido;
    }

    if (count($productos) > 0) {
    } else {
        echo "<div class='no-products'>
        <p class='msg-no-products'>No se han encontrado productos en la categoría : <strong>$nombre_cate</strong> </p>
        </div>";
    }
} else if(isset($_REQUEST['idProducto'])){
    $id_producto = $_REQUEST['idProducto'];
    $cant = $_REQUEST['cant'];
    $idPedido = $_REQUEST['idPedido'];
    $producto = $productos->traerProducto($gbd, $id_producto);

    $id = $producto['id'];
    $nombre = $producto['nombre'];
    $precio_sin_iva = $producto['precio_sin_iva'];
    $subtotal = $cant * $precio_sin_iva;

    $comprobar = $pedidos->compruebaDetallePedido($gbd, $idPedido, $id_producto);
    //var_dump($comprobar);
    if($comprobar->rowCount() > 0){
        $valida=$comprobar->fetch(PDO::FETCH_ASSOC);
        $cant = $valida['cant'];
        $cant_new = $cant + 1;
        echo 'agrega';
        echo 'Ya existe. Nuevo valor:  '.$cant_new;
        $actualiza_cant = $pedidos->actualizaDetallePedido($gbd, $idPedido, $id_producto, $cant_new);
        var_dump($actualiza_cant);
    }else{
        $insert = $pedidos->agregarDetallePedido($gbd, $idPedido, $id_producto, $cant);
        if($insert){
            echo '<tr id="fila'.$id.'">
    <td><input class="form-control input-cant" id="cant'.$id.'" type="text" value="'.$cant.'" onkeyup="calcularSubtotal('.$id.')"></td>
    <td>'.$nombre.'</td>
    <td hidden id="pu'.$id.'">'.$precio_sin_iva.'</td>
    <td class="col-subtotal" id="subtotal'.$id.'">'.$subtotal.'</td>
    <th><button class="button-trash" onclick="eliminarFilaProducto('.$id.');">
    <i class="fa-solid fa-xmark"></i></button>
    </th>
    </tr>';
        }else{
            echo "error: ".$insert;
        }
    }
} else {
    echo 'No llega id';
}

if(isset($_REQUEST['eliminar'])){
    $eliminar = $_REQUEST['eliminar'];
    $pedido = $_REQUEST['idPedido'];
    $producto = $_REQUEST['idProducto'];
    if($eliminar = 'true'){
        $trash =$pedidos->eliminarDetallePedido($gbd, $pedido, $producto);
        if($trash){
            echo 'elimino';
        }else{
            var_dump($trash);
        }
    }
}

if(isset($_REQUEST['actualiza_cant'])){
    $actualiza = $_REQUEST['actualiza_cant'];
    $cant = $_REQUEST['cant'];
    $producto = $_REQUEST['idProducto'];
    $pedido = $_REQUEST['idPedido'];
    if($actualizar = 'true'){
        $actualizar=$pedidos->actualizaDetallePedido($gbd, $pedido, $producto, $cant);
        if($actualizar){
            echo 'cambia_cant';
        }else{
            var_dump($actualizar);
        }
    }
}
?>


