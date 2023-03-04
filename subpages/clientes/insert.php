<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../class/conexion.php';
include '../../subpages/functions.php';
include '../../class/clientes/cliente.class.php';

$clientes = new Cliente();

$nombre = $cedula = $direccion = $email = $telefono = $celular = '';
$nombre_valida = $cedula_valida = $direccion_valida = $email_valida = $telefono_valida = $celular_valida = false;
if (isset($_REQUEST['cedula'])) {
    if (empty($_POST["cedula"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Debe ingresar un número de cédula.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        return;
    } else {
        $cedula = validar_input($_POST["cedula"]);
        if (!is_numeric($_POST["cedula"])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El campo #Documento solo recibe números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            return;
        } elseif (strlen($_POST["cedula"]) != 10) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El #Documento debe tener 10 números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            return;
        } else {
            $cedula_valida = true;
        }
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
if (isset($_REQUEST['celular'])) {
    if (empty($_POST["celular"])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ingresa un Celular.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        return;
    } else {
        $celular = validar_input($_POST["celular"]);
        if (!is_numeric($_POST["celular"])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El campo Celular, solo permite números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } elseif (strlen($_POST["celular"]) != 10) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El Celular debe tener 10 números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } else {
            $celular_valida = true;
        }
    }
}
if (isset($_REQUEST['telefono'])) {
    if (empty($_POST["telefono"])) {
        $telefono_valida = true;
    } else {
        $telefono = validar_input($_POST["telefono"]);
        if (!is_numeric($_POST["telefono"])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El campo Teléfono, solo permite números.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } elseif (strlen($_POST["telefono"]) != 9) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            El teléfono debe tener 9 números. Formato: <strong>Código de la provincia, seguido del número de teléfono. Ejemplo: 020000000</strong> Sin espacios.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            return;
        } else {
            $telefono_valida = true;
        }
    }
}
if ($nombre_valida == true && $direccion_valida == true && $cedula_valida == true && $email_valida == true && $telefono_valida == true && $celular_valida == true) {
    //echo 'ENTRA';
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $update = $clientes->actualizarCliente($gbd, $id, $nombre, $cedula, $email, $direccion, $telefono, $celular);
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
        //compueba que no exista el cliente
        $select=$clientes->validaCliente($gbd, $email, $cedula);
        if ($select->rowCount() > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                El cliente ya se encuentra registrado
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            //guarda el nuevo cliente
            $insert=$clientes->guardarCliente($gbd,$nombre, $cedula, $email, $direccion, $telefono, $celular);
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

?>

