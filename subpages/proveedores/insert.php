<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../subpages/functions.php';
//echo 'LLEGA';
$nombre_comercial = $nombre_contacto = $ruc = $direccion = $email = $telefono = $celular = $observacion = '';
$nombre_comercial_valida = $nombre_contacto_valida = $ruc_valida = $direccion_valida = $email_valida = $telefono_valida = $celular_valida = $observacion_valida = '';
if (isset($_REQUEST['ruc'])) {
    if (empty($_POST["ruc"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Debe ingresar el RUC. <strong>Los últimos 3 dígitos serán 001</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $ruc = validar_input($_POST["ruc"]);
        if (!is_numeric($_POST["ruc"])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El campo RUC solo recibe números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            return;
        } else if (strlen($_POST["ruc"]) != 13) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El RUC debe tener 13 números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            return;
        } else if(!validaRuc($_POST["ruc"])){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Formato de RUC inválido.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        } else {
            $ruc_valida = true;
        }
    }
}
if (isset($_REQUEST['nombre_comercial'])) {
    if (empty($_POST['nombre_comercial'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Debe ingresar un nombre comercial.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $nombre_comercial = validar_input($_POST['nombre_comercial']);
        if (!isValid($nombre_comercial)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                El campo Nombre Comercial solo acepta letras.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            return;
        } else {
            $nombre_comercial_valida = true;
        }
    }
}
if (isset($_REQUEST['nombre_contacto'])) {
    if (empty($_POST['nombre_contacto'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Debe ingresar un nombre de contacto.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $nombre_contacto = validar_input($_POST['nombre_contacto']);
        if (!isValid($nombre_contacto)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                El campo Nombre de Contacto solo acepta letras.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            return;
        } else {
            $nombre_contacto_valida = true;
        }
    }
}
if (isset($_REQUEST['email'])) {
    if (empty($_POST["email"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa un correo eléctrónico.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $email = validar_input($_POST["email"]);
        // Verifica el correcto formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Formato de email invalido.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            return;
        } else {
            $email_valida = true;
        }
    }
}
if (isset($_REQUEST['telefono'])) {
    if (empty($_POST["telefono"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa un teléfono.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        return;
    } else {
        $telefono = validar_input($_POST["telefono"]);
        if (!is_numeric($_POST["telefono"])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El campo Teléfono, solo permite números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } elseif (strlen($_POST["telefono"]) != 10) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El teléfono debe tener 10 números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } else {
            $telefono_valida = true;
        }
    }
}
if (isset($_REQUEST['celular'])) {
    $celular = $_REQUEST['celular'];
    $celular_valida = true;
}
if (isset($_REQUEST['direccion'])) {
    if (empty($_POST["direccion"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa una dirección.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $direccion = validar_input($_POST["direccion"]);
        $direccion_valida = true;
    }
}
if (isset($_REQUEST['observacion'])) {
    $observacion = $_REQUEST['observacion'];
    $observacion_valida = true;
}

if($nombre_comercial_valida == true && $nombre_contacto_valida == true && $ruc_valida == true && $email_valida == true && $telefono_valida == true && $celular_valida == true && $direccion_valida == true && $observacion_valida == true){
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $query = "update proveedores set nombre_comercial='$nombre_comercial', nombre_contacto='$nombre_contacto', ruc='$ruc', email='$email', direccion='$direccion', telefono='$telefono', celular='$celular', observacion='$observacion' where id=$id";
        $update = $gbd->prepare($query);
        $update->execute();
        //var_dump($update);
        if($update){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Se actualizó el Proveedor
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                No se pudo actualizar el Proveedor.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    } else {
        //query para registrar el nuevo Proveedor.
        $query = "select * from proveedores where email=? or ruc=? ";
        $select = $gbd->prepare($query);
        $select->execute(array($email, $ruc));
        if ($select->rowCount() > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                El Proveedor ya se encuentra registrado
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            $query = "insert into proveedores (nombre_comercial, nombre_contacto, ruc, email, direccion, telefono, celular, observacion) 
                values('$nombre_comercial', '$nombre_contacto', '$ruc', '$email', '$direccion', '$telefono', '$celular', '$observacion') ";
            $insert = $gbd->prepare($query);
            $insert->execute();
            //var_dump($insert);
            if ($insert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Se agregó el Proveedor a la base de datos.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    No se pudo crear el Proveedor. Error: '.$insert.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
    }
}

?>
