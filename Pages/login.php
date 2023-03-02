<?php
include '../class/conexion_admin.php';
session_start();
if($_SESSION['email'] && $_SESSION['inicia'] = 1){
    header("Location: ./inicio.php");
}

$email_Err = $pass_Err = "";
$email = $pass = "";
$valida_email = $valida_pass = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $email_Err = "Ingresa tu correo electrónico.";
    } else {
        $email = $_POST["email"];
        $valida_email = true;
    }

    if (empty($_POST["pass"])) {
        $pass_Err = "Ingresa una contraseña.";
    } else {
        $pass = md5($_POST['pass']);
        $valida_pass = true;
    }
}

if ($valida_email == true && $valida_pass == true) {
    //Hacer query para la base de datos.
    $query = "select * from empresas where email=:email and pass=:pass ";
    $consulta = $gbd->prepare($query);
    $consulta->bindValue(':email', $email);
    $consulta->bindValue(':pass', $pass);
    $consulta->execute();
    if ($consulta -> rowCount()>0) {
        $rowconsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        var_dump($rowconsulta);
        $_SESSION['email']=$email;
        $_SESSION['inicia']=1;
        $_SESSION['id']=$rowconsulta['id'];
        $_SESSION['empresa']=$rowconsulta['empresa'];
        $_SESSION['nombre_contacto']=$rowconsulta['nombre_contacto'];
        $_SESSION['telefono_contacto']=$rowconsulta['telefono_contacto'];
        $_SESSION['direccion']=$rowconsulta['direccion'];
        header("location:inicio.php");
    } else {
        echo 'se cerro la conexion';
        session_destroy();
        header("location:login.php");
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
    <title>Ailee - Login</title>
</head>

<body>
    <div id="wrapper">
        <div id="contenedor">
            <div id="contenido">
                <img src="../assets/img/aile-logo-green-t.png" width=100px alt="">
                <br>
                <h4>BIENVENIDO</h4>
                <br>
                <div class="contenedor-login">
                    <form action="login.php" method="post">
                        <div class="form-input">
                            <input class="input" placeholder="Usuario" type="text" name="email" id="email">
                            <span class="input-border"></span>
                        </div>
                        <span class="error"><?php echo $email_Err ?></span>
                        <br>
                        <div class="form-input">
                            <input class="input" placeholder="Contraseña" type="password" name="pass" id="pass">
                            <span class="input-border"></span>
                        </div>
                        <span class="error"><?php echo $pass_Err ?></span>
                        <br>
                        <center>
                            <button type="submit" class="btn-login">Ingresar</button>
                        </center>
                    </form>
                </div>
                <br>
                <span class="span-msg">¿Aún no tienes una cuenta? <a class="a-register" href="register.php">Registrate</a>.</span>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>