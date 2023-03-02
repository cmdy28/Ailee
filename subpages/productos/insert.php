<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../subpages/functions.php';

$nombre = $categoria = $descripcion = $codigo = $precio_sin_iva = $precio_con_iva = $es_materia_prima = $en_el_menu = $estado = $color = $impuesto_iva = $impuesto_servicio = '';
$nombre_valida = $categoria_valida = $descripcion_valida = $codigo_valida = $precio_sin_iva_valida = $precio_con_iva_valida = $es_materia_prima_valida = $en_el_menu_valida = $estado_valida = $color_valida = $impuesto_iva_valida = $impuesto_servicio_valida = false;

if (isset($_REQUEST['codigo'])) {
    if (empty($_POST["codigo"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa un código.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $codigo = validar_input($_POST["codigo"]);
        $codigo_valida = true;
    }
}
if (isset($_REQUEST['nombre'])) {
    if (empty($_POST['nombre'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Debe ingresar un nombre.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $nombre = validar_input($_POST['nombre']);
        $nombre_valida = true;
    }
}
if (isset($_REQUEST['categoria'])) {
    if (empty($_POST['categoria'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Selecciona una categoria.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $categoria = validar_input($_POST['categoria']);
        $categoria_valida = true;
    }
}
if(isset($_REQUEST['categoria'])){
    $categoria = $_REQUEST['categoria'];
    $categoria_valida = true;
}
if (isset($_REQUEST['descripcion'])) {
    $descripcion = validar_input($_POST["descripcion"]);
    $descripcion_valida = true;
}
if (isset($_REQUEST['precio_sin_iva'])) {
    if (empty($_POST["precio_sin_iva"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa un Precio.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
        $precio_sin_iva = $_POST["precio_sin_iva"];
        $precio_sin_iva_valida = true;
    }
}
if (isset($_REQUEST['precio_con_iva'])) {
    if (empty($_POST["precio_con_iva"])) {
        return;
    } else {
        $precio_con_iva = $_POST["precio_con_iva"];
            $precio_con_iva_valida = true;
    }
}
if (isset($_REQUEST['es_materia_prima'])){
    if($_REQUEST['es_materia_prima'] = 'on'){
        $es_materia_prima = 'true';
        $es_materia_prima_valida = true;
    }
}else{
    $es_materia_prima = 'false';
    $es_materia_prima_valida = true;
}
if (isset($_REQUEST['en_el_menu'])){
    if($_REQUEST['en_el_menu'] = 'on'){
        $en_el_menu = 'true';
        $en_el_menu_valida = true;
    }
}else{
    $en_el_menu = 'false';
    $en_el_menu_valida = true;
}
if (isset($_REQUEST['estado'])){
    if($_REQUEST['estado'] = 'on'){
        $estado = 3;
        $estado_valida = true;
    }
}else{
    $estado = 4;
    $estado_valida = true;
}
if (isset($_REQUEST['impuesto_iva'])){
    if($_REQUEST['impuesto_iva'] = 'on'){
        $impuesto_iva = 'true';
        $impuesto_iva_valida = true;
    }
}else{
    $impuesto_iva = 'false';
    $impuesto_iva_valida = true;
}
if (isset($_REQUEST['impuesto_servicio'])){
    if($_REQUEST['impuesto_servicio'] = 'on'){
        $impuesto_servicio = 'true';
        $impuesto_servicio_valida = true;
    }
}else{
    $impuesto_servicio = 'false';
    $impuesto_servicio_valida = true;
}
if (isset($_REQUEST['color'])){
   $color = $_REQUEST['color'];
   $color_valida = true;
}

if ($nombre_valida == true && $descripcion_valida == true && $categoria_valida == true && $codigo_valida == true 
&& $precio_sin_iva_valida == true && $precio_con_iva_valida == true && $es_materia_prima_valida == true 
&& $en_el_menu_valida == true && $estado_valida == true && $impuesto_iva_valida == true && $impuesto_servicio_valida == true 
&& $color_valida == true) {
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $query = "update productos set nombre='$nombre', categoria='$categoria', codigo='$codigo', descripcion='$descripcion', 
        precio_sin_iva='$precio_sin_iva', precio_con_iva='$precio_con_iva', es_materia_prima=$es_materia_prima, incluir_en_menu=$en_el_menu, 
        estado=$estado, impuesto_iva=$impuesto_iva, impuesto_servicio=$impuesto_servicio, color='$color' where id=$id";
        $update = $gbd->prepare($query);
        $update->execute();
        //var_dump($update);
        if ($update) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Se actualizó el producto
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                No se pudo actualizar el producto.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    } else {
        //query para registrar el nuevo producto.
        $query = "select * from productos where codigo=? or nombre=? ";
        $select = $gbd->prepare($query);
        $select->execute(array($codigo, $nombre));
        if ($select->rowCount() > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                El producto ya se encuentra registrado
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            $query = "insert into productos (nombre, categoria, codigo, descripcion, precio_sin_iva, precio_con_iva, 
            es_materia_prima, incluir_en_menu, estado, impuesto_iva, impuesto_servicio, color) 
                values('$nombre', $categoria, '$codigo', '$descripcion', $precio_sin_iva, $precio_con_iva, 
                $es_materia_prima, $en_el_menu, $estado, $impuesto_iva, $impuesto_servicio, '$color') ";
            $insert = $gbd->prepare($query);
            $insert->execute();
            var_dump($insert);
            if ($insert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Se agregó el producto a la base de datos.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    No se pudo crear el producto. Error: '.$insert.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
    }
}
