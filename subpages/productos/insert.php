<?php
$color = '';
$estado = '';
$descripcion = '';
$es_materia_prima = '';
if(isset($_REQUEST['color'])){
    $color = $_REQUEST['color'];
}else{
    echo 'ERROR';
}
if(isset($_REQUEST['descripcion'])){
    $descripcion = $_REQUEST['descripcion'];
}else{
    echo 'ERROR';
}
if(isset($_REQUEST['estado'])){
    $estado = $_REQUEST['estado'];
    if($estado == 'on'){
        $estado = 'true';
    }
}else{
    $estado = 'false';
}
if(isset($_REQUEST['es_materia_prima'])){
    $es_materia_prima = $_REQUEST['es_materia_prima'];
    if($es_materia_prima == 'on'){
        $es_materia_prima = 'true';
    }
}else{
    $es_materia_prima = 'false';
}

//echo 'Color: '.$color.'<br>Es Materia Prima: '.$es_materia_prima.'<br> Estado: '.$estado.'<br> Descripción: '.$descripcion;
?>