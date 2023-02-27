<?php
function cerrarSesion(){
    session_destroy();
}
//Validación de inputs de los formularios.
function validar_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//Valida que se ingrese solo texto.
function isValid($text){
    $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
    $response = preg_match($pattern, $text);
    if($response){
        return true;
    }else{
        return false;
    }
}
//Valida el RUC ingresado
function validaRuc($ruc){
    $response = preg_match("/001$/", $ruc); // Devuelve: 1
    if($response){
        return true;
    }else{
        return false;
    }
}

?>