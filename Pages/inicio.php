<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Guayaquil');
require_once '../class/public.class.php';
session_start();
$init = new InitTicket();
$title=$init->title;
$empresa=$_SESSION['empresa'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css"> -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../plugins/fontawesome-free-6.2.1-web/css/all.min.css">
    <!-- bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- icon -->
    <link rel="shortcut icon" href="../assets/img/ailee-green-bg-dark-t-logo.png" type="image/x-icon">
    <!-- estilos -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/app.css">
    <!-- <script src="../plugins/bootstrap/js/bootstrap.min.js"></script> -->
    <title><?php echo $title; ?></title>
    <style>
    /* .form-control:focus {
        color: var(--bs-body-color);
        background-color: var(--bs-form-control-bg);
        border-color: #d1d1d1;
        outline: none;
        box-shadow: none;
    }
    .fa-solid{
        color:#8b8b8b;
    } */
    </style>
</head>

<body>
    <div class="menu-header">
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

    <!-- <footer> © Ailee - 2023</footer> -->
    <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    </script>
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