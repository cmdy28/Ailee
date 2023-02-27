<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
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
    $sql = " select * from productos where id=$id_producto";
    $stmtex3 = $gbd->query($sql);
    $stmtex3->execute();
    $producto = $stmtex3->fetch(PDO::FETCH_ASSOC);

    $id = $producto['id'];
    $nombre = $producto['nombre'];
    $precio_sin_iva = $producto['precio_sin_iva'];
    $subtotal = $cant * $precio_sin_iva;

    echo '<tr id="fila'.$id.'">
    <td><input class="form-control input-cant" type="number" value="'.$cant.'"></td>
    <td>'.$nombre.'</td>
    <td class="col-subtotal">'.$subtotal.'</td>
    <th><button class="button-trash" onclick="eliminarFilaProducto('.$id.');">
    <i class="fa-solid fa-xmark"></i></button>
    </th>
    </tr>';
} else {
    echo 'No llega id';
}
?>

