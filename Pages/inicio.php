<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Guayaquil');
require_once '../class/public.class.php';
$init = new InitTicket;
$title=$init->title;
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
    <link rel="stylesheet" href="../css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    <title><?php echo $title; ?></title>
</head>

<body>
    <div>
        <?php 
        include './apariencia/header.php';
        include './apariencia/menu.php';
        ?>
    </div>
    <br>
    <div class="subpages">
        <?php
		    include $init->subpagePath;
		?>
    </div>

    <!-- crear alerta -->
    <script>
    function showAlert(type, message, duration) {
        if (!message) return false;
        if (!type) type = 'info';
        $("<div class='alert alert-message alert-" +
            type +
            " data-alert alert-dismissible'>" +
            "<button class='close alert-link' data-dismiss='alert'>&times;</button>" +
            message + " </div>").hide().appendTo('body').fadeIn(300);
        if (duration === undefined) {
            duration = 5000;
        }
        if (duration !== false) {
            $(".alert-message").delay(duration).fadeOut(500, function() {
                $(this).remove();
            });
        }
    }
    </script>
</body>

</html>