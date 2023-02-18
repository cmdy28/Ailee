<?php
include '../class/conexion_admin.php';
include '../subpages/functions.php';
// Definir variables
$empresa_Err = $email_Err = $direccion_Err = $telefono_Err = $nombre_contacto_Err = $pass_Err = "";
$empresa = $email = $direccion = $telefono_contacto = $nombre_contacto = $pass = "";
$valida_empresa = $valida_direccion = $valida_email = $valida_pass = $valida_telefono = $valida_nombre_contacto = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["empresa"])) {
        $empresa_Err = "Ingresa el nombre de tu empresa.";
    } else {
        $empresa = validar_input($_POST["empresa"]);
        if (!ctype_alpha($empresa)) {
            $empresa_Err = "Ingresa solo letras.";
        } else {
            $valida_empresa = true;
        }
    }

    if (empty($_POST["direccion"])) {
        $direccion_Err = "Ingresa una dirección.";
    } else {
        $direccion = validar_input($_POST["direccion"]);
        $valida_direccion = true;
    }

    if (empty($_POST["email"])) {
        $email_Err = "Ingresa un correo electrónico.";
    } else {
        $email = validar_input($_POST["email"]);
        // Verifica el correcto formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_Err = "Formato de email invalido.";
        } else {
            $valida_email = true;
        }
    }

    if (empty($_POST["telefono_contacto"])) {
        $telefono_Err = "Ingresa un teléfono de contacto.";
    } else {
        $telefono_contacto = validar_input($_POST["telefono_contacto"]);
        if (!is_numeric($_POST["telefono_contacto"])) {
            $telefono_Err = "Solo se permiten números.";
        } elseif (strlen($_POST["telefono_contacto"]) != 10) {
            $telefono_Err = "Ingresa un teléfono válido";
        } else {
            $valida_telefono = true;
        }
    }

    if (empty($_POST["nombre_contacto"])) {
        $nombre_contacto_Err = "Ingresa un nombre de contacto.";
    } else {
        $nombre_contacto = validar_input($_POST["nombre_contacto"]);
        if (!isValid($nombre_contacto)) {
            $nombre_contacto_Err = "Ingresa solo letras.";
        } else {
            $valida_nombre_contacto = true;
        }
    }

    if (empty($_POST["pass"])) {
        $pass_Err = "Ingresa una contraseña.";
    } else {
        $pass = validar_input($_POST["pass"]);
        if (strlen($pass) < 8) {
            $pass_Err = "La clave debe tener al menos 8 caracteres";
        } elseif (strlen($pass) > 16) {
            $pass_Err = "La clave no puede tener más de 16 caracteres";
        } /*elseif (!preg_match('`[a-z]`', $pass)) {
            $pass_Err = "La clave debe tener al menos una letra minúscula";
        } elseif (!preg_match('`[A-Z]`', $pass)) {
            $pass_Err = "La clave debe tener al menos una letra mayúscula";
        } elseif (!preg_match('`[0-9]`', $pass)) {
            $pass_Err = "La clave debe tener al menos un caracter numérico";
        }*/ else {
            $valida_pass = true;
            $pass = md5($pass);
        }
    }
}

if ($valida_empresa == true && $valida_direccion == true && $valida_email == true && $valida_pass == true && $valida_telefono == true && $valida_nombre_contacto == true) {
    //Hacer query para la base de datos.
    $query = "select empresa, direccion, email, pass, telefono_contacto, nombre_contacto from empresas where email=? and empresa=? ";
    $select = $gbd->prepare($query);
    $select->execute(array($email, $empresa));
    //verificamos que no exista la empresa.
    if ($select->rowCount() > 0) {
        echo '
                <script>
                    alert("La empresa ya se encuentra registrada.");
                    window.location="register.php";
                </script>
            ';
    } else {
        $query = "insert into empresas (empresa, direccion, email, pass, telefono_contacto, nombre_contacto) 
        values(:empresa, :direccion, :email, :pass, :telefono_contacto, :nombre_contacto) RETURNING id";
        $insert = $gbd->prepare($query);
        $insert->bindValue(':nombre_contacto', $nombre_contacto);
        $insert->bindValue(':empresa', $empresa);
        $insert->bindValue(':direccion', $direccion);
        $insert->bindValue(':telefono_contacto', $telefono_contacto);
        $insert->bindValue(':email', $email);
        $insert->bindValue(':pass', $pass);
        $insert->execute();

        if ($insert->rowCount() > 0) {
            $rowin = $insert->fetch(PDO::FETCH_ASSOC);
            $idregistro = $rowin['id'];
        }

        // $base = 'base_'.$idregistro;
        // $query = "update empresas set base=:base where id=:id";
        // $insert = $gbd->prepare($query);
        // $insert->bindValue(':base', $base);
        // $insert->bindValue(':id', $id);
        // $insert->execute();

        if ($insert) {
            echo '
                    <script>
                        alert("Tu cuenta se creo con éxito, por favor inicia sesión.");
                        window.location="login.php";
                    </script>
                ';
        } else {
            echo '
                    <script>
                        alert("Fallo al crear tu cuenta.");
                        window.location="registro.php";
                    </script>
                ';
        }
        // if ($insert->rowCount() > 0) {
        //     $rowin = $insert->fetch(PDO::FETCH_ASSOC);
        //     $idregistro = $rowin['id'];
        // }

        // $querytabladata = 'CREATE TABLE public.data' . $idregistro . ' (
        //     id bigserial NOT NULL,
        //     fecha timestamptz NULL,
        //     ip varchar(120) NULL,
        //     agent text NULL,
        //     referer text NULL,
        //     lat text NULL,
        //     lng text NULL,
        //     navigator text NULL,
        //     platform text NULL,
        //     cookie text NULL,
        //     footprint text NULL,
        //     eljson text NULL,
        //     "first" bool NULL DEFAULT false,
        //     loadtime text NULL,
        //     id_user int8 NULL,
        //     "location" text NULL,
        //     "name" varchar(250) NULL,
        //     "unique_id" text NULL,
        //     "country_code" text NULL,
        //     "country_name" text NULL,
        //     CONSTRAINT data_pkey' . $idregistro . ' PRIMARY KEY (id)
        // )';
        // $createtable = $gbd->prepare($querytabladata);
        // $createtable->execute();


        // $querytabladata2 = "CREATE TABLE public.tiempos" . $idregistro . " (
        //     id bigserial NOT NULL,
        //     fecha timestamp NULL,
        //     users int8 NULL,
        //     tiempo float8 NULL,
        //     jsonpaginas text NOT NULL DEFAULT ''::text,
        //     CONSTRAINT tiempos_pkey" . $idregistro . " PRIMARY KEY (id))";
        // $createtable2 = $gbd->prepare($querytabladata2);
        // $createtable2->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../plugins/fontawesome-free-6.2.1-web/css/all.min.css">
    <link rel="shortcut icon" href="../assets/img/ailee-green-bg-dark-t-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <title>Ailee - Registro</title>
<style>
    .span-order {
        font-size: 16px;
        font-weight: bold;
    }

    select#tipo_negocio.input {
        font-size: 15px;
    }

    select#tipo_negocio.input:focus {
        outline: none;
    }
</style>
</head>

<body>
    <div id="wrapper">
        <div id="contenedor">
            <div id="contenido">
                <img src="../assets/img/aile-logo-green-t.png" width=100px alt="">
                <br>
                <h4>Crea tu cuenta</h4>
                <br>
                <div class="contenedor-registro">
                    <form action="../pages/register.php" method="post" id="register">
                        <span class="span-order">Datos Básicos</span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input class="input" placeholder="Nombre de contacto" name="nombre_contacto"
                                        id="nombre_contacto" type="text">
                                    <span class="input-border"></span>
                                </div>
                                <span class="error"><?php echo $nombre_contacto_Err ?></span>
                                <div class="form-input">
                                    <input class="input" placeholder="Teléfono de contacto" name="telefono_contacto"
                                        id="telefono_contacto" type="text">
                                    <span class="input-border"></span>
                                </div>
                                <span class="error"><?php echo $telefono_Err?></span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input class="input" placeholder="Correo Electrónico" name="email" id="email"
                                        type="text">
                                    <span class="input-border"></span>                                   
                                </div>
                                <span class="error"><?php echo $email_Err ?></span>
                                <div class="form-input">
                                    <input class="input" placeholder="Contraseña" name="pass" id="pass" type="password">
                                    <span class="input-border"></span>
                                </div>
                                <span class="error"><?php echo $pass_Err?></span>
                            </div>
                        </div>
                        <br>
                        <span class="span-order">Datos de tu Empresa</span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input class="input" placeholder="Nombre del Negocio" name="empresa"
                                        id="empresa" type="text">
                                    <span class="input-border"></span>
                                </div>
                                <span class="error"><?php echo $empresa_Err ?></span>
                            </div>
                            <div class="col-md-6">
                                <!-- <div class="form-input">
                                    <select name="tipo_negocio" id="tipo_negocio" class="input">
                                        <option value="">Tipo de Negocio</option>
                                        <option value="1">Bar y Cafetería</option>
                                        <option value="2">Fast Food</option>
                                    </select>
                                    <span class="input-border"></span>
                                </div> -->
                                <div class="form-input">
                                    <input class="input" placeholder="Dirección" name="direccion" id="direccion"
                                        type="text">
                                    <span class="input-border"></span>
                                </div>
                                <span class="error"><?php echo $direccion_Err?></span>
                            </div>
                        </div>
                        <!-- <div class="form-input">
                            <input class="input" placeholder="Dirección" name="direccion" id="direccion"  type="text">
                            <span class="input-border"></span>
                        </div> -->
                        <br>
                        <center>
                            <button type="submit" class="btn-login">Registrar</button>
                        </center>
                    </form>
                </div>
                <br>
                <span class="span-msg">¿Ya tienes una cuenta? <a class="a-register" href="login.php">Inicia
                        Sesión</a>.</span>
            </div>
        </div>
    </div>



</body>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<!-- enviar formulario -->
<!-- <script type="text/javascript">
$('#register').submit(function() { // catch the form's submit event
    $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            //console.log(response);
            $('#respuesta').html(response);
        },
        error: function(response) {
            $('#respuesta').html(response);
        }
    });
    return false; // cancel original event to prevent form submitting
}); -->
</script>
</html>