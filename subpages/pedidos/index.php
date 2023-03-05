<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
include '../class/provision/categoria.class.php';
include '../class/clientes/cliente.class.php';
include '../class/provision/producto.class.php';
include '../class/pedidos/pedido.class.php';
$productos = new Producto();
$categorias = new Categoria();
$clientes = new Cliente();
$pedidos = new Pedido();

$datos = $categorias->traerCategorias($gbd);
$clientes = $clientes->traerClientes($gbd);
$productos = $productos->traerProductos($gbd);

//Crear pedido y retornar id
$pedido = $pedidos->crearPedido($gbd);
$idpedido=$pedido['id'];

if (isset($_REQUEST['idmesa'])) {
    $mesa=$_REQUEST['idmesa'];
} else {
    $mesa='';
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
        <div class="div-new">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="" class="form-label">Cliente</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping"><i
                                        class="fa-solid fa-user"></i></span>
                                <select class="form-control" name="cliente" data-placeholder="Buscar Cédula / Cliente"
                                    id="cliente">
                                    <?php
                                        foreach ($clientes as $client) {
                                            $clienteText = strtoupper($client['cedula'].' | '.$client['nombre']);
                                            if($client['id'] == 2){
                                                echo '<option value='.$client['id'].' selected>'.$clienteText.'</option>';    
                                            }
                                            echo '<option value='.$client['id'].'>'.$clienteText.'</option>';
                                        }
                                    ?>
                                    <!-- <option value="0">Nueva Categoría</option> -->
                                </select>
                                <span class="input-group-text span-client" id="addon-wrapping">
                                    <button type="button" class="btn btn-modal" data-bs-toggle="modal"
                                        data-bs-target="#clienteModal">
                                        <a type="button" class="a-client" data-bs-toggle="tooltip"
                                            data-bs-title="Crear Cliente">
                                            <i class="fa-solid fa-circle-plus"></i>
                                        </a>
                                    </button>

                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form action="?modulo=menu" method="post">
                                <label for="nombre" class="form-label">Productos</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-box"></i></span>
                                    <select class="form-control" data-placeholder="Buscar Producto / Código"
                                        name="producto" id="producto" onchange="agregarProducto(this.value);">
                                        <option value=""></option>
                                        <?php
                                            foreach ($productos as $product) {
                                                $productoText = strtoupper($product['codigo'].' | '.$product['nombre']);
                                                echo '<option value='.$product['id'].'>'.$productoText.'</option>';
                                            }
                                        ?>
                                        <!-- <option value="0">Nueva Categoría</option> -->
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 div-filtro">
                            <label for="categoria">Filtrar por Categoría</label>
                            <div class="div-categorias">
                                <?php
                                    foreach ($datos as $cate) {
                                        //echo '<a class="link-categoria" href="?modulo=menu&categoria='.$cate['id'].'"><div class="container-link-categoria" style="background-color:'.$cate['color'].'">'.$cate['nombre'].'</div></a>';
                                        echo '<a class="link-categoria" href="#" onclick="cambiaCategoria('.$cate['id'].');">
                                        <div class="container-link-categoria" style="background-color:'.$cate['color'].'">'.$cate['nombre'].'</div>
                                        </a>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="container-productos" id="container-productos">
                                <div class="row" id="product-content">
                                    <?php
                                        foreach ($productos as $product) {
                                            $productNombre = $product['nombre'];
                                            echo '<div class="col-md-2 col-product">
                                            <button class="btn-product" onclick="agregarProducto('.$product['id'].');">
                                            <div class="container-producto" style="background-color:'.$product['color'].'">
                                                <span class="text-producto">'.$product['nombre'].'</span>
                                                <br>
                                                <span class="text-producto-precio">$'.$product['precio_sin_iva'].'</span>
                                            </div>
                                            </button>
                                            </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="div-facturacion">
                        <br>
                        <h5 class="text-light" style="font-weight:bold">Total</h5>
                        <h3 class="text-light" id="total">$ 0</h3>
                        <button type="button" class="btn btn-guardar" onclick="guardar(2)">
                            Facturar
                        </button>
                        <a onclick="guardar(1)" class="btn btn-primary" type="button">Guardar</a>
                        <br>
                        <br>
                    </div>
                    <div class="div-subtotal">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="subtotal-iva">Subtotal</span>
                                <p class="valor-precio" id="subtotal">$0</p>
                            </div>
                            <div class="col-md-6">
                                <span class="subtotal-iva">IVA (12%)</span>
                                <p class="valor-precio" id="iva">$0</p>
                            </div>
                        </div>
                    </div>
                    <div class="tabla-pedido">
                        <table class="table" id="tablaPedido">
                            <thead class="table-dark">
                                <tr>
                                    <th width="15%">Cant.</th>
                                    <th width="40%">Producto</th>
                                    <th width="10%" hidden>$ P/U</th>
                                    <th width="20%">Subtotal</th>
                                    <th width="15%"><i class="fa-solid fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody class="tbody-pedido">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Cliente -->
    <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="respuesta"></div>
                    <form id="formCliente" action='../subpages/clientes/insert.php' name="formCliente" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="cedula">#Documento</label>
                                <div class="input-group flex-nowrap ">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-id-card"></i></span>
                                    <input class="form-control" placeholder="#Documento" name="cedula" id="cedula"
                                        type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="nombre">Nombre</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-user"></i></span>
                                    <input class="form-control" placeholder="Nombre" name="nombre" id="nombre"
                                        type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="email">Correo Electrónico</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-envelope"></i></span>
                                    <input class="form-control" placeholder="Correo Electrónico" name="email"
                                        id="email">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="direccion">Dirección</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-location-dot"></i></span>
                                    <input class="form-control" placeholder="Dirección" name="direccion" id="direccion"
                                        type="text">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="celular">Celular</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-phone"></i></span>
                                    <input class="form-control" placeholder="Celular (5555551234)" name="celular"
                                        id="celular" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="telefono">Teléfono</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-phone"></i></span>
                                    <input class="form-control" placeholder="Teléfono (00 000 0000)" name="telefono"
                                        id="telefono" type="text">
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-guardar">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Factura -->
    <div class="modal fade" id="facturaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="facturaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header header-modal-factura">
                    <div>
                        <h1>¡Factura Generada con Éxito!</h1>
                    </div>
                </div>
                <div class="modal-body factura-modal-body">
                    <h2>TOTAL</h2>
                    <H1 id="total-factura">$0.00</H1>
                </div>
                <div class="modal-footer div-botones-factura">
                    <button type="button" class="btn btn-guardar btn-lg" onclick="imprimeFactura();">
                        IMPRIMIR
                    </button>
                    <button type="button" class="btn btn-primary btn-lg" onclick="location.reload();">OK</button>
                </div>
            </div>
        </div>
    </div>


    <!-- enviar formulario -->
    <script type="text/javascript">
    // $('#cliente').select2();
    $('#cliente').selectize();
    $('#producto').selectize();

    $('#formCliente').submit(function() { // catch the form's submit event
        $.ajax({ // create an AJAX call...
            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: $(this).attr('action'), // the file to call
            success: function(response) { // on success..
                console.log(response);
                var comprobar = response.includes("agreg");
                if (comprobar == true) {
                    $('#clienteModal').modal('hide');
                    var form = document.getElementById('formCliente');
                    form.reset();
                    location.reload();
                } else {
                    $('#respuesta').html(response);
                }
            },
            error: function(response) {
                $('#respuesta').html(response);
            }
        });

        return false; // cancel original event to prevent form submitting
    });

    function obtenerNumeros(string) {
        var tmp = string.split("");
        var map = tmp.map(function(current) {
            if (!isNaN(parseInt(current))) {
                return current;
            }
        });

        var numbers = map.filter(function(value) {
            return value != undefined;
        });

        return numbers.join("");
    }
    </script>
    <script>
    function guardar(opc) {
        var opc = opc;
        var idPedido = <?php echo $idpedido ?>;
        var subtotal = $("#subtotal").text();
        var iva = $("#iva").text();
        var total = $("#total").text();
        var cliente = $("#cliente").val();
        console.log('CLIENTE: '+cliente);
        dataString = {
            'mesa': <?php echo $mesa?>,
            'idPedido': idPedido,
            'subtotal': subtotal,
            'iva': iva,
            'total': total,
            'cliente': cliente,
            'opc': opc
        };
        $.ajax({ // create an AJAX call...
            data: dataString, // get the form data
            type: $(this).attr('method'), // GET or POST
            url: '../subpages/pedidos/guarda_factura.php', // the file to call
            success: function(response) { // on success..
                if (opc == 1) {
                    console.log(response);
                    location.reload();
                }
                if (opc == 2) {
                    console.log(response);
                    $("#facturaModal").modal("show");
                }
            },
            error: function(response) {
                console.log(response);
            }
        });

        return false; // cancel original event to prevent form submitting
    }

    function imprimeFactura(){
        window.open('../template/print_templates/print_factura.php?pedido=<?php echo $idpedido ?>', '_blank', 'location=yes,height=670,width=720,scrollbars=yes,status=yes');
        location.reload();
    }
    </script>
    <script>
    function cambiaCategoria(id) {
        var idCategoria = id;
        dataString = {
            'idCategoria': idCategoria
        };
        $.ajax({
            url: "../subpages/pedidos/traer_productos.php",
            type: "POST",
            data: dataString,
            success: function(response) {
                $('#product-content').html(response);
                //alert(response);
            },
            error: function(response) {
                //alert('error' + response);
                $('#container-productos').html('Error: ' + response);
            }
        });
    }

    function agregarProducto(id) {
        //identificar fila con el parametro id
        var idProducto = id;
        var cant = 1;
        var idPedido = <?php echo $idpedido ?>;
        //$("#tablaPedido>tbody").append("<tr><td>"+ cant +"</td><td>"+ nombre +"</td><td>"+ subtotal +"</td><th><button class='button-trash'><i class='fa-solid fa-xmark'></i></button></th></tr>");

        dataString = {
            'idProducto': idProducto,
            'cant': cant,
            'idPedido': idPedido
        };
        $.ajax({
            url: "../subpages/pedidos/traer_productos.php",
            type: "POST",
            data: dataString,
            success: function(response) {
                console.log(response);
                var comprobar = response.includes("agrega");
                if (comprobar == true) {
                    var cant = $("#cant" + idProducto).val();
                    var newCant = parseFloat(cant) + 1;
                    $("#cant" + idProducto).val(newCant);
                    calcularSubtotal(idProducto);
                } else {
                    $("#tablaPedido>tbody").append(response);
                    calcularValores();
                }

                //alert(response);
            },
            error: function(response) {
                alert('Error al agregar el producto. \n Error:' + response);
                //$('#container-productos').html('Error: ' + response);
            }
        });
    }

    function calcularValores() {
        var sum = 0;
        $('.col-subtotal').each(function() {
            sum += parseFloat($(this).text());
        });
        var subtotal = sum.toFixed(2);
        var iva = (sum.toFixed(2) * 0.12).toFixed(2);
        var total = (parseFloat(subtotal) + parseFloat(iva)).toFixed(2);

        $('#subtotal').html("$" + subtotal);
        $('#iva').html("$" + iva);
        $('#total').html("$" + total);
        $('#total-factura').html("$" + total);
    }

    function calcularSubtotal(id) {
        var cant = $("#cant" + id).val();
        // var precioUnitario = $("#pu" + id).text();
        // var newSubtotal = parseFloat(precioUnitario) * parseFloat(cant);
        // $("#subtotal" + id).text(newSubtotal.toFixed(2));
        // calcularValores();
        var idProducto = id;
        var idPedido = <?php echo $idpedido ?>;

        dataString = {
            'idProducto': idProducto,
            'idPedido': idPedido,
            'actualiza_cant': 'true',
            'cant': cant
        };
        $.ajax({
            url: "../subpages/pedidos/traer_productos.php",
            type: "POST",
            data: dataString,
            success: function(response) {
                var comprobar = response.includes("cambia_cant");
                if (comprobar == true) {
                    var precioUnitario = $("#pu" + id).text();
                    var newSubtotal = parseFloat(precioUnitario) * parseFloat(cant);
                    $("#subtotal" + id).text(newSubtotal.toFixed(2));
                    calcularValores();
                } else {}
            },
            error: function(response) {
                alert('Error: ' + response);
                //$('#container-productos').html('Error: ' + response);
            }
        });
    }

    function eliminarFilaProducto(index) {
        //identificar fila con el parametro id
        var idProducto = index;
        var idPedido = <?php echo $idpedido ?>;

        dataString = {
            'idProducto': idProducto,
            'idPedido': idPedido,
            'eliminar': 'true'
        };
        $.ajax({
            url: "../subpages/pedidos/traer_productos.php",
            type: "POST",
            data: dataString,
            success: function(response) {
                var comprobar = response.includes("elimino");
                if (comprobar == true) {
                    $("#fila" + index).remove();
                    calcularValores();
                } else {}
            },
            error: function(response) {
                alert('Error: ' + response);
                //$('#container-productos').html('Error: ' + response);
            }
        });
    }
    </script>
</body>

</html>