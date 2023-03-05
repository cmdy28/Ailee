<?php 
# Nuestra base de datos
include '../../class/conexion.php';
include '../../class/clientes/cliente.class.php';
include '../../class/pedidos/pedido.class.php';
include '../../class/provision/producto.class.php';
include '../../class/pedidos/factura.class.php';
session_start();

$clientes = new Cliente();
$pedidos = new Pedido();
$facturas = new Factura();
$productos = new Producto();

$empresa= $_SESSION['empresa'];
$direccion_empresa=$_SESSION['direccion'];
$email_empresa= $_SESSION['email'];
$telefono_empresa=$_SESSION['telefono_contacto'];
$datos_empresa=$direccion_empresa.'<br>'.$email_empresa.'<br>'.$telefono_empresa;

if(isset($_REQUEST['pedido'])){
    $pedido = $_REQUEST['pedido'];
}

$detalle_pedido=$pedidos->traerDetallePedido($gbd, $pedido);
$factura=$pedidos->traerFacturaDetallePedido($gbd, $pedido);
$idFactura=$factura['factura'];

$datos_factura=$facturas->traerFactura($gbd, $idFactura);
$clienteid=$datos_factura['cliente'];
$fecha=$datos_factura['fecha'];
$subtotal=$datos_factura['subtotal'];
$iva=$datos_factura['iva'];
$total=$datos_factura['total'];

$divFactura='<strong>Fecha: </strong>'.$fecha.'<br><strong>Forma de Pago: </strong>Efectivo';

$cliente=$clientes->traerCliente($gbd, $clienteid);
$cedula=$cliente['cedula'];
$nombre=$cliente['nombre'];
$telefono=$cliente['celular'];
$direccion=$cliente['direccion'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
    .factura {
        float: right;
    }

    p {
        font-size: 12px;
        font-weight: 500;
    }

    .valores {
        font-size: 23px;
        text-align: right;
    }

    .center {
        text-align: center;
    }
    .datos{
        font-size:12px;
    }
    </style>
</head>

<body onload="imprimir();">
    <div class="container">
        <br>
        <h1><?php echo $empresa;?></h1>
        <table>
            <tr>
                <th width="500px">
                    <p><?php echo $datos_empresa;?></p>
                </th>
                <th width="500px" style="text-align:right;">
                    <h4><strong>FACTURA N°: </strong><?php echo '00'.$idFactura;?> </h4>
                    <p><?php echo $divFactura?></p>
                </th>
            </tr>
        </table>
        <hr>
        <p><strong>Datos del cliente</strong></p>
        <table>
            <tr>
                <th width="500px">
                    <p><strong>C.I.: </strong><?php echo $cedula;?></p>
                    <p><strong>Nombre: </strong><?php echo $nombre;?></p>
                </th>
                <th width="500px">
                    <p><strong>Teléfono: </strong><?php echo $telefono;?></p>
                    <p><strong>Dirección: </strong><?php echo $direccion;?></p>
                </th>
            </tr>
        </table>


        <hr>

        <table class="table datos">
            <thead>
                <tr>
                    <th scope="col">Cant.</th>
                    <th scope="col">Descripción</th>
                    <th scope="col" class="center">Precio Unitario</th>
                    <th scope="col" class="center">Precio Total</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php 
                foreach($detalle_pedido as $dp){
                    $producto=$productos->traerProducto($gbd, $dp['producto']);
                    $nombre=$producto['nombre'];
                    $precio=$producto['precio_sin_iva'];
                    $precio_total=$precio * $dp['cant'];
                    echo '<tr>
                    <th scope="row">'.$dp['cant'].'</th>
                    <td>'.$nombre.'</td>
                    <td class="center">'.number_format($precio, 2).'</td>
                    <td class="center">'.number_format($precio_total, 2).'</td>
                </tr>';
                }
                ?>
            </tbody>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">
                        <div class="valores">
                            <p><strong>SUBTOTAL: </strong><?php echo number_format($subtotal, 2);?></p>
                            <p><strong>IVA (12%): </strong><?php echo number_format($iva, 2);?></p>
                            <p><strong>TOTAL: </strong><?php echo number_format($total, 2);?></p>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>


        <br>
        <br>
        <br>
    </div>


    <script type="text/javascript">
    function imprimir() {
        if (window.print) {
            window.print();
        } else {
            alert("La función de impresion no esta soportada por su navegador.");
        }
    }
    </script>
</body>


</html>