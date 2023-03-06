<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
include '../class/clientes/cliente.class.php';
include '../class/provision/producto.class.php';
include '../class/pedidos/pedido.class.php';
include '../class/pedidos/factura.class.php';
$productos = new Producto();
$clientes = new Cliente();
$pedidos = new Pedido();
$facturas= new Factura();

$datosFacturas=$facturas->traerFacturas($gbd);

?>
<div class="container-fluid">
    <div class="div-new">
        <div>
            <!-- <a href="#"><Button class="btn btn-nuevo">Importar</Button></a> -->
            <!-- <a href="?modulo=nuevocliente"><Button class="btn btn-nuevo">Nuevo Cliente</Button></a>
            <h5>Clientes</h5> -->
        </div>
        <hr>
        <!-- <div>
            <div class="row">
                <div class="col-md-5">
                    <form action="?modulo=clientes" method="post" class="form">
                        <button>
                            <svg height="20" fill="none" xmlns="http://www.w3.org/2000/svg" role="img"
                                aria-labelledby="search">
                                <path
                                    d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                                    stroke="currentColor" stroke-width="1.333" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                        </button>
                        <input class="input" placeholder="Buscar Cliente / Cédula / Email" name="search" id="search" type="text">
                    </form>
                </div>
                <div class="col-md-6">
                    <a href="../template/exceltemplates/excel_clientes.php">
                        <button class="btn btn-icon" >
                            <i class="fa-solid fa-file-excel" style="font-size:27px; color:#000"></i>
                        </button>
                    </a>
                    <button class="btn btn-icon"><i class="fa-solid fa-file-pdf" style="font-size:27px; color:#000"></i></button>
                </div>
            </div>
        </div> -->
        <br>
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-light-table">
                    <tr>
                        <th scope="col" width=15%>Fecha</th>
                        <th scope="col" width=30%>Cliente</th>
                        <th scope="col" width=30%>Documento</th>
                        <th scope="col" width=15%>Total</th>
                        <th scope="col" width=10% style="text-align:center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($datosFacturas as $data) {
                        $idCliente=$data['cliente'];
                        $cliente=$clientes->traerCliente($gbd, $idCliente);
                        $nombreCliente=$cliente['nombre'];

                        $pedido=$facturas->traerPedidoFactura($gbd, $data['id']);
                        $idPedido=$pedido['pedido'];
                        echo '<tr>
                        <th scope="row">'.$data['fecha'].'</th>
                        <td>'.$nombreCliente.'</td>
                        <td>N° 00'.$data['id'].'<br>(Factura)</td>
                        <td>$ '.$data['total'].'</td>
                        <td style="text-align:center">
                            <a href="?modulo=detallePedido&pedido='.$idPedido.'">
                                <button class="btn btn-edit">
                                    <i class="fa-solid fa-eye" style="font-size:18px; color:#000"></i>
                                </button>
                            </a>
                        </td>
                    </tr>';
                    }
?>
                </tbody>
            </table>

        </div>
    </div>
</div>