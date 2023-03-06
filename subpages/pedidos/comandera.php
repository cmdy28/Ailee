<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
include '../class/clientes/cliente.class.php';
include '../class/provision/producto.class.php';
include '../class/pedidos/pedido.class.php';
$productos = new Producto();
$clientes = new Cliente();
$pedidos = new Pedido();

$datos_pedidos = $pedidos->traerPedidosEstado($gbd, 6);

//función calcular tiempo
$strTimeAgo = "";

function timeago($date){
    $timestamp = strtotime($date);

    $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        return "Hace " . $diff . " " . $strTime[$i] . "(s)";
    }
}
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
                <div id="reloj" class="reloj">
                    00 : 00 : 00
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($datos_pedidos as $dp) {
                    $idPedido = $dp['id'];
                    $fechaPedido = $dp['fecha'];
                    $calculo_tiempo = timeago($fechaPedido);

                    $detalle_pedido = $pedidos->traerDetallePedido($gbd, $idPedido);
                    foreach($detalle_pedido as $dp){
                        $factura = $dp['factura'];
                    }
                    $mesa_pedido = $pedidos->traerMesaPedido($gbd, $idPedido);

                    echo '<div class="col-md-3">
                    <div class="container-comandera-pedido">
                        <div class="comandera-div-header">
                            <span>'.$fechaPedido.'</span>
                            <br>
                            <span id="tiempo-pedido'.$idPedido.'"><i class="fa-regular fa-clock"></i> '.$calculo_tiempo.'</span>
                        </div><div class="comandera-div-content">';

                        if($mesa_pedido->rowCount() > 0){
                            $mp=$mesa_pedido->fetch(PDO::FETCH_ASSOC);
                                $idmesa=$mp['mesa'];
                                $mesas=$pedidos->traerMesa($gbd, $idmesa);
                                $nombreMesa=$mesas['nombre'];
                                echo '<div class="comandera-mesa">
                            '.$nombreMesa.'- <i class="fa-solid fa-utensils"></i>
                        </div>';
                            
                         
                        }else{
                                echo '<div class="comandera-mesa">
                            Factura N° 00'.$factura.' - <i class="fa-solid fa-utensils"></i>
                        </div>';
                        }
                        echo '<div class="div-comandera-products">';
                        foreach($detalle_pedido as $detalle){
                            $id=$detalle['id'];
                            $cant=$detalle['cant'];
                            $idProducto = $detalle['producto'];
                            $product = $productos->traerProducto($gbd, $idProducto);
                            $nombre = $product['nombre'];
                            echo '
                            <div class="comandera-products">
                                <strong>'.$cant.'</strong>  '.$nombre.'
                            </div>
                            ';
                        }
                        echo '</div><hr>
                        <div class="comandera-despacha">
                            <button class="btn btn-guardar" onclick="despachar('.$idPedido.');">Despachar</button>
                        </div>
                    </div>
                </div>
            </div>';
                }
?>
            </div>
        </div>
    </div>



    <script>
    function actual() {
        fecha = new Date(); //Actualizar fecha.
        hora = fecha.getHours(); //hora actual
        minuto = fecha.getMinutes(); //minuto actual
        segundo = fecha.getSeconds(); //segundo actual
        if (hora < 10) { //dos cifras para la hora
            hora = "0" + hora;
        }
        if (minuto < 10) { //dos cifras para el minuto
            minuto = "0" + minuto;
        }
        if (segundo < 10) { //dos cifras para el segundo
            segundo = "0" + segundo;
        }
        //ver en el recuadro del reloj:
        mireloj = hora + " : " + minuto + " : " + segundo;
        return mireloj;
    }

    function actualizar() { //función del temporizador
        mihora = actual(); //recoger hora actual
        mireloj = document.getElementById("reloj"); //buscar elemento reloj
        mireloj.innerHTML = mihora; //incluir hora en elemento
    }

    function actualizarCalculoTiempo(id) {

        $("#tiempo-pedido" + id).load(location.href + " #tiempo-pedido" + id);
    }
    setInterval(actualizar, 1000); //iniciar temporizador
    setInterval(actualizarCalculoTiempo, 1000);
    </script>

    <script>
    function despachar(id) {
        var idPedido = id;
        dataString = {
            'idPedido': idPedido
        };
        $.ajax({
            url: "../subpages/pedidos/cambia_pedido.php",
            type: "POST",
            data: dataString,
            success: function(response) {
                console.log(response);
                var comprobar = response.includes("cambio");
                if (comprobar == true) {
                    location.reload();
                }

            },
            error: function(response) {
                console.log(response);
            }
        });
    }
    </script>
</body>

</html>