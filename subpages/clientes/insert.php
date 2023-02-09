<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';

//echo 'LLEGA';
$opcion='';
$nombre = '';
$cedula = '';
$direccion = '';
$email = '';
$telefono = '';
$celular = '';
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
}
if (isset($_REQUEST['nombre'])) {
    $nombre = $_REQUEST['nombre'];
}
if (isset($_REQUEST['cedula'])) {
    $cedula = $_REQUEST['cedula'];
}
if (isset($_REQUEST['email'])) {
    $email = $_REQUEST['email'];
}
if (isset($_REQUEST['direccion'])) {
    $direccion = $_REQUEST['direccion'];
}
if (isset($_REQUEST['telefono'])) {
    $telefono = $_REQUEST['telefono'];
}
if (isset($_REQUEST['celular'])) {
    $celular = $_REQUEST['celular'];
}

if (isset($_REQUEST['id'])) {
    $query = "update clientes set nombre='$nombre', cedula='$cedula', email='$email', direccion='$direccion', telefono='$telefono', celular='$celular' where id=$id";
    $update = $gbd->prepare($query);
    $update->execute();
    //var_dump($update);
    if($update){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Se actualizó el cliente
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }else{
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            No se pudo actualizar el cliente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
} else {
    //query para registrar el nuevo cliente.
    $query = "select * from clientes where email=? or cedula=? ";
    $select = $gbd->prepare($query);
    $select->execute(array($email, $cedula));
    if ($select->rowCount() > 0) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El cliente ya se encuentra registrado
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $query = "insert into clientes (nombre, cedula, email, direccion, telefono, celular) 
            values('$nombre', '$cedula', '$email', '$direccion', '$telefono', '$celular') ";
        $insert = $gbd->prepare($query);
        $insert->execute();
        //var_dump($insert);
        if ($insert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Se agregó el cliente a la base de datos.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                No se pudo crear el cliente. Error: '.$insert.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
}




