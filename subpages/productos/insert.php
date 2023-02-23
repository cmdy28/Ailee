<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../subpages/functions.php';

$nombre = $categoria = $descripcion = $codigo = $precio_sin_iva = $precio_con_iva = $es_materia_prima = $en_el_menu = $estado = $color = '';
$nombre_valida = $categoria_valida = $descripcion_valida = $codigo_valida = $precio_sin_iva_valida = $precio_con_iva_valida = $es_materia_prima_valida = $en_el_menu_valida = $estado_valida = $color_valida = false;
if (isset($_REQUEST['codigo'])) {
    if (empty($_POST["codigo"])) {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
            Si no ingresa un código, el sistema le asignará uno.
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
        if (!isValid($nombre)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                El campo nombre solo acepta letras.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            return;
        } else {
            $nombre_valida = true;
        }
    }
}

if (isset($_REQUEST['descripcion'])) {
    $descripcion = validar_input($_POST["descripcion"]);
    $descripcion_valida = true;
}
if (isset($_REQUEST['precio_con_iva'])) {
    if (empty($_POST["precio_con_iva"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa un Precio.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        return;
    } else {
        $precio_con_iva = validar_input($_POST["precio_con_iva"]);
        if (!is_float($_POST["precio_con_iva"])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Formato Inválido <br>Ingresa un precio con este formato: <strong>0.00</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } else {
            $precio_con_iva_valida = true;
        }
    }
}
if (isset($_REQUEST['precio_sin_iva'])) {
    if (empty($_POST["precio_sin_iva"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa un Precio.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
        $precio_sin_iva = validar_input($_POST["precio_sin_iva"]);
        if (!is_numeric($_POST["precio_sin_iva"])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Formato Inválido <br>Ingresa un precio con este formato: <strong>0.00</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } else {
            $precio_sin_iva_valida = true;
        }
    }
}


//echo $nombre_valida.'<br>'.$categoria_valida.'<br>'.$codigo_valida.'<br>'.$descripcion_valida.'<br>'.$precio_sin_iva_valida.'<br>'.$precio_con_iva_valida;

if ($nombre_valida == true && $descripcion_valida == true && $categoria_valida == true && $codigo_valida == true && $precio_sin_iva_valida == true && $precio_con_iva_valida == true) {
    //echo 'ENTRA';
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $query = "update clientes set nombre='$nombre', categoria='$categoria', codigo='$codigo', descripcion='$descripcion', precio_sin_iva='$precio_sin_iva', precio_con_iva='$precio_con_iva' where id=$id";
        $update = $gbd->prepare($query);
        $update->execute();
        //var_dump($update);
        if ($update) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Se actualizó el cliente
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                No se pudo actualizar el cliente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    } else {
        //query para registrar el nuevo cliente.
        $query = "select * from clientes where codigo=? or categoria=? ";
        $select = $gbd->prepare($query);
        $select->execute(array($codigo, $categoria));
        if ($select->rowCount() > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                El cliente ya se encuentra registrado
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            $query = "insert into clientes (nombre, categoria, codigo, descripcion, precio_sin_iva, precio_con_iva) 
                values('$nombre', '$categoria', '$codigo', '$descripcion', '$precio_sin_iva', '$precio_con_iva') ";
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
}
