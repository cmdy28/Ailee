<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
# Nuestra base de datos
include '../class/conexion.php';
include '../class/clientes/cliente.class.php';
include '../class/pedidos/pedido.class.php';
include '../class/provision/producto.class.php';
include '../class/pedidos/factura.class.php';

$clientes = new Cliente();
$pedidos = new Pedido();
$facturas = new Factura();
$productos = new Producto();

$empresa= $_SESSION['empresa'];
$direccion_empresa=$_SESSION['direccion'];
$email_empresa= $_SESSION['email'];
$telefono_empresa=$_SESSION['telefono_contacto'];
$datos_empresa=$direccion_empresa.'<br>'.$email_empresa.'<br>'.$telefono_empresa;

if (isset($_REQUEST['pedido'])) {
    $pedido = $_REQUEST['pedido'];
}

$detalle_pedido=$pedidos->traerDetallePedido($gbd, $pedido);
if (!$detalle_pedido) {
    echo 'No hay registros';
}
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
    <style>
    .factura {
        float: right;
    }

    p {
        font-size: 14px;
        font-weight: 500;
    }

    .valores {
        font-size: 23px;
        text-align: right;
    }

    .center {
        text-align: center;
    }

    .datos {
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="div-new">
            <br>
            <div style="text-align:right;">
                <a href="?modulo=historial"><Button class="btn btn-regresar">Regresar</Button></a>
                <button class="btn" data-bs-toggle="tooltip" data-bs-title="Imprimir" onclick="imprimeFactura();"><i
                        class="fa-solid fa-print" style="font-size:20px"></i></button>
            </div>
            <hr>
            <table class="table table-borderless">
                <tr>
                    <th width="600px">
                        <p><?php echo $datos_empresa;?></p>
                    </th>
                    <th width="700px" style="text-align:right;">
                        <h4><strong>FACTURA N° </strong><?php echo '00'.$idFactura;?> </h4>
                        <p><?php echo $divFactura?></p>
                    </th>
                </tr>
            </table>
            <hr>
            <p><strong>Datos del cliente</strong></p>
            <table class="table table-borderless">
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
                foreach ($detalle_pedido as $dp) {
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
    </div>


    <script type="text/javascript">
    function imprimeFactura() {
        window.open('../template/print_templates/print_factura.php?pedido=<?php echo $pedido ?>', '_blank',
            'location=yes,height=700,width=1200,scrollbars=yes,status=yes');
        location.reload();
    }
    </script>
</body>


</html>