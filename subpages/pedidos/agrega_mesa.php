<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
$nombre = $cant = '';
$nombre_valida = $cant_valida = false;

if (isset($_REQUEST['nombre'])) {
    if (empty($_POST['nombre'])) {
        echo '<div class="error" >Debe darle un nombre a la mesa.</div>';
        return;
    } else {
        $nombre = strtoupper($_REQUEST['nombre']);
        $nombre_valida = true;
    }
}
if (isset($_REQUEST['cant'])) {
    if (empty($_POST["cant"])) {
        echo '<div class="error">Debe ingresar para cuantas personas es la mesa.</div>';
        return;
    } else {
        $cant = $_REQUEST['cant'];
        $cant_valida = true;
    }
}

if ($nombre_valida == true && $cant_valida == true) {
    $query = "select * from mesas where nombre=? ";
    $select = $gbd->prepare($query);
    $select->execute(array($nombre));
    if ($select->rowCount() > 0) {
        echo '<div class="error">Ya hay una mesa con ese nombre. Ingrese un nombre diferente.</div>';
    } else {
        $query = "insert into mesas (nombre, cant) 
                values('$nombre', $cant) ";
        $insert = $gbd->prepare($query);
        $insert->execute();
        //var_dump($insert);
        if ($insert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Se agrego la mesa.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } else {
            echo '<div class="error" >No se pudo agregar la mesa. Error: '.$insert.'</div>';
        }
    }
}
