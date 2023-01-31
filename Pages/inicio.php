<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Guayaquil');
require_once './class/public.class.php';
$init = new InitTicket;
$title=$init->title;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./plugins/bootstrap/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./plugins/fontawesome-free-6.2.1-web/css/all.min.css">
    <title><?php echo $title; ?></title>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
    }

    /* .subpages {
        margin-top: 40px;
    } */

    /* Dropdown Button */
    .dropbtn {
        background-color: transparent;
        color: white;
        padding: 4px;
        font-size: 16px;
        border: none;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f1f1f1;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: transparent;
    }

    .nav-link-down {
        padding: 11px;
        font-size: 18px;
    }

    .text-content {
        font-size: 15px;
    }
    </style>
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


    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="./plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>