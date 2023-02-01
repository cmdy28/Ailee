<?php
include '../class/conexion.php';
// Definir variables
$nombre_Err = $emailErr = $apellidoErr = $telErr = $websiteErr = $passErr = "";
$nombre = $email = $apellido = $tel = $website = $pass = "";
$valida_nombre = $valida_apellido = $valida_email = $valida_pass = $valida_tel = $valida_website = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nombre"])) {
        $nombre_Err = "Nombre es requerido!";
    } else {
        $nombre = validar_input($_POST["nombre"]);
        if (!ctype_alpha($nombre)) {
            $nombre_Err = "Ingresa solo letras!";
        } else {
            $valida_nombre = true;
        }
    }

    if (empty($_POST["apellido"])) {
        $apellidoErr = "Apellido es requerido!";
    } else {
        $apellido = validar_input($_POST["apellido"]);
        if (!ctype_alpha($apellido)) {
            $apellidoErr = "Ingresa solo letras!";
        } else {
            $valida_apellido = true;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email es requerido";
    } else {
        $email = validar_input($_POST["email"]);
        // Verifica el correcto formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato de email invalido";
        } else {
            $valida_email = true;
        }
    }

    if (empty($_POST["tel"])) {
        $telErr = "Teléfono es requerido!";
    } else {
        $tel = validar_input($_POST["tel"]);
        if (!is_numeric($_POST["tel"])) {
            $telErr = "Numbers only !";
        } else if (strlen($_POST["tel"]) != 10) {
            $telErr = "10 characters only !";
        } else {
            $valida_tel = true;
        }
    }

    if (empty($_POST["website"])) {
        $websiteErr = "Website es requerido";
    } else {
        $website = validar_input($_POST["website"]);
        // Verifica el correcto formato de email
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Formato de url invalido";
        } else {
            $valida_website = true;
        }
    }

    if (empty($_POST["pass"])) {
        $passErr = "Contraseña es requerido";
    } else {
        $pass = validar_input($_POST["pass"]);
        if (strlen($pass) < 6) {
            $passErr = "La clave debe tener al menos 6 caracteres";
        } else if (strlen($pass) > 16) {
            $passErr = "La clave no puede tener más de 16 caracteres";
        } /*else if (!preg_match('`[a-z]`', $pass)) {
            $passErr = "La clave debe tener al menos una letra minúscula";
        } else if (!preg_match('`[A-Z]`', $pass)) {
            $passErr = "La clave debe tener al menos una letra mayúscula";
        } else if (!preg_match('`[0-9]`', $pass)) {
            $passErr = "La clave debe tener al menos un caracter numérico";
        }*/ else {
            $valida_pass = true;
            $pass = md5($pass);
        }
    }
}

if ($valida_nombre == true && $valida_apellido == true && $valida_email == true && $valida_pass == true && $valida_tel == true && $valida_website == true) {
    //Hacer query para la base de datos.
    $query = "select nombre, apellido, email, pass, telefono, website from usuario where email=? ";
    $select = $gbd->prepare($query);
    $select->execute(array($email));


    if ($select->rowCount() > 0) {

        echo '
                <script>
                    alert("Ya se encuentra un usuario registrado con ese correo");
                    window.location="registro.php";
                </script>
             ';
    } else {


        $query = "insert into usuario (nombre, apellido, email, pass, telefono, website, fecha_ingreso) 
        values(?,?,?,?,?,?,?) RETURNING id";
        $insert = $gbd->prepare($query);
        $insert->execute(array($nombre, $apellido, $email, $pass, $tel, $website, 'now()'));

        if ($insert->rowCount() > 0) {
            $rowin = $insert->fetch(PDO::FETCH_ASSOC);
            $idregistro = $rowin['id'];
        }

        $clave = $email . "moitoru2021" . "_" . $idregistro;
        $mipass = password_hash($clave, PASSWORD_BCRYPT);

        $query1 = "update usuario set apikey=? where id=?";
        $update = $gbd->prepare($query1);
        $update->execute(array($mipass, $idregistro));

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

function validar_input($data){
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
                <h4>Crea tu cuenta gratis!</h4>
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
                                    <input class="input" placeholder="Teléfono de contacto" name="telefono"
                                        id="telefono" type="text">
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
                                    <input class="input" placeholder="Nombre del Negocio" name="nombre_negocio"
                                        id="nombre_negocio" type="text">
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


    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>