<?php
include 'conex.php';
$opcion = $_REQUEST['opc'];
if($opcion = 1){
    echo 'entra<br>';
    saluda();
}else{
    echo ' no saluda';
}

?>