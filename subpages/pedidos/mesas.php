<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
$sql2 = " select * from mesas";
$stmtex = $gbd->query($sql2);
$stmtex->execute();
$datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div>
        <div class="div-new">
            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2"><button class="btn btn-nuevo">Nueva Mesa</button></div>
            </div>
            <hr>
            <div class="row">
                <?php 
                foreach($datos as $mesa){
                    if($mesa['estado'] == 1){
                        $icon = '../assets/img/img-app/libre.png';
                    }
                    if($mesa['estado'] == 2){
                        $icon = '../assets/img/img-app/ocupado.png';
                    }
                    echo '<div class="col-md-2 div-container-mesa">
                    <div class="div-mesa"><button class="btn-mesa"></button>
                    <img src="'.$icon.'" width="150px" alt="">
                    <p class="nombre-mesa">'.$mesa['nombre'].'</p>
                </button></div>
                </div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>