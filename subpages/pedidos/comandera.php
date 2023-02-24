<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
$sql2 = " select * from mesas";
$stmtex = $gbd->query($sql2);
$stmtex->execute();
$datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);
$fecha = date("d-m-Y h:i:s");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container-fluid">
    <div id="respuesta"></div>
        <div class="div-new">
            <div class="row header-comandera">
                <h5>00:00:00</h5>
                <h5><?php echo $fecha?></h5>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="container-comandera-pedido">
                    <div class="comandera-div-header">
                        <span>Fecha y Hora de abrir el pedido</span>
                        <br>
                        <span><i class="fa-regular fa-clock"></i> 16 minutos</span>
                    </div>
                    <div class="comandera-div-content">
                        <div class="comandera-mesa">
                            Mesa 6 - <i class="fa-solid fa-utensils"></i>
                        </div>
                        <hr>
                        <div class="comandera-products">
                           <li>Producto1</li>
                           <li>Producto 2</li> 
                        </div>
                        <hr>
                        <div class="comandera-despacha">
                            <button class="btn btn-guardar">Despachar</button>
                        </div>
                    </div>
                    </div>
                </div>
                <?php 
                // foreach($datos as $mesa){
                //     if($mesa['estado'] == 1){
                //         $icon = '../assets/img/img-app/libre.png';
                //     }
                //     if($mesa['estado'] == 2){
                //         $icon = '../assets/img/img-app/ocupado.png';
                //     }
                //     echo '<div class="col-md-2 div-container-mesa">
                //     <div class="div-mesa"><button class="btn-mesa">
                //     <img src="'.$icon.'" width="150px" alt="">
                //     <p class="nombre-mesa">'.$mesa['nombre'].'</p>
                //     </button></div>
                // </div>';
                // }
                ?>
            </div>
        </div>
    </div>


    <!-- Modal Nueva mesa -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Mesa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
            <form action="../subpages/pedidos/agrega_mesa.php" method="post" id="mesaForm">
            <div>
                        <label for="nombre">Nombre Mesa</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-utensils"></i></span>
                            <input class="form-control" placeholder="" name="nombre" id="nombre"
                                type="text">
                        </div>
                    </div>
                    <div>
                        <label for="cant">Capacidad</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-hashtag"></i></span>
                            <input class="form-control" placeholder="" name="cant" id="cant"
                                type="number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-regresar" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-guardar" data-bs-dismiss="modal">Guardar</button>
                    </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>



</body>

</html>