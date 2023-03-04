<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../class/provision/categoria.class.php';
$categorias = new Categoria();

$nombre = $color = '';
$nombre_valida = $color_valida = false;

if (isset($_REQUEST['categoria_new'])) {
    if (empty($_POST['categoria_new'])) {
        echo '<div class="error" >Ingrese el nombre de la categoría.</div>';
        return;
    } else {
        $nombre = strtoupper($_REQUEST['categoria_new']);
        $nombre_valida = true;
    }
}
if(isset($_REQUEST['color'])){
    $color=$_REQUEST['color'];
    $color_valida = true;
}

if ($nombre_valida == true && $color_valida == true) {
    $select=$categorias->validaCategoria($gbd, $nombre);
    if ($select->rowCount() > 0) {
        echo '<div class="error">Esta categoría ya existe. Ingrese una categoría diferente.</div>';
    } else {
        $insert=$categorias->guardarCategoria($gbd, $nombre, $color);
        //var_dump($insert);
        if ($insert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Se agrego la categoría.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } else {
            echo '<div class="error" >No se pudo agregar la categoría. Error: '.$insert.'</div>';
        }
    }
}