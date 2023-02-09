<?php
include '../class/conexion.php';
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
        } else if (strlen($_POST["telefono_contacto"]) != 10) {
            $telefono_Err = "Ingresa un teléfono válido";
        } else {
            $valida_telefono = true;
        }
    }

    if (empty($_POST["nombre_contacto"])) {
        $nombre_contacto_Err = "Ingresa un nombre de contacto.";
    } else {
        $nombre_contacto = validar_input($_POST["nombre_contacto"]);
        $valida_nombre_contacto = true;
    }

    if (empty($_POST["pass"])) {
        $pass_Err = "Ingresa una contraseña.";
    } else {
        $pass = validar_input($_POST["pass"]);
        if (strlen($pass) < 6) {
            $pass_Err = "La clave debe tener al menos 8 caracteres";
        } else if (strlen($pass) > 16) {
            $pass_Err = "La clave no puede tener más de 16 caracteres";
        } else if (!preg_match('`[a-z]`', $pass)) {
            $pass_Err = "La clave debe tener al menos una letra minúscula";
        } else if (!preg_match('`[A-Z]`', $pass)) {
            $pass_Err = "La clave debe tener al menos una letra mayúscula";
        } else if (!preg_match('`[0-9]`', $pass)) {
            $pass_Err = "La clave debe tener al menos un caracter numérico";
        } else {
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
        $query = "insert into usuario (empresa, direccion, email, pass, telefono_contacto, nombre_contacto) 
        values(?,?,?,?,?,?,?) RETURNING id";
        $insert = $gbd->prepare($query);
        $insert->execute(array($empresa, $direccion, $email, $pass, $telefono_contacto, $nombre_contacto));

        if ($insert->rowCount() > 0) {
            $rowin = $insert->fetch(PDO::FETCH_ASSOC);
            $idregistro = $rowin['id'];
        }
        
        $querytabladata = 'CREATE TABLE public.data' . $idregistro . ' (
            id bigserial NOT NULL,
            fecha timestamptz NULL,
            ip varchar(120) NULL,
            agent text NULL,
            referer text NULL,
            lat text NULL,
            lng text NULL, 
            navigator text NULL,
            platform text NULL,
            cookie text NULL,
            footprint text NULL,
            eljson text NULL,
            "first" bool NULL DEFAULT false,
            loadtime text NULL,
            id_user int8 NULL,
            "location" text NULL,
            "name" varchar(250) NULL,
	        "unique_id" text NULL,
            "country_code" text NULL,
            "country_name" text NULL,
            CONSTRAINT data_pkey' . $idregistro . ' PRIMARY KEY (id)
        )';
        $createtable = $gbd->prepare($querytabladata);
        $createtable->execute();


        $querytabladata2 = "CREATE TABLE public.tiempos" . $idregistro . " (
            id bigserial NOT NULL,
            fecha timestamp NULL,
            users int8 NULL,
            tiempo float8 NULL,
            jsonpaginas text NOT NULL DEFAULT ''::text,
            CONSTRAINT tiempos_pkey" . $idregistro . " PRIMARY KEY (id))";
        $createtable2 = $gbd->prepare($querytabladata2);
        $createtable2->execute();
    }




    //$ejecutar = pg_query($conexion,$query);

    if ($insert) {
        echo '
                   <script>
                       alert("Registro exitoso, por favor inicia sesión.");
                       window.location="login.php";
                   </script>
                ';
    } else {
        echo '
                <script>
                    alert("Fallo al ingresar al usuario a la base de datos.");
                    window.location="registro.php";
                </script>
             ';
    }
}

function validar_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
                    <form action="" method="post">
                        <span class="span-order">Datos Básicos</span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input class="input" placeholder="Nombre de contacto" name="nombre_contacto"
                                        id="nombre_contacto" type="text">
                                    <span class="input-border"></span>
                                </div>
                                <div class="form-input">
                                    <input class="input" placeholder="Teléfono de contacto" name="telefono_contacto"
                                        id="telefono_contacto" type="text">
                                    <span class="input-border"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input class="input" placeholder="Correo Electrónico" name="email" id="email"
                                        type="text">
                                    <span class="input-border"></span>
                                </div>
                                <div class="form-input">
                                    <input class="input" placeholder="Contraseña" name="pass" id="pass" type="text">
                                    <span class="input-border"></span>
                                </div>
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

</html>