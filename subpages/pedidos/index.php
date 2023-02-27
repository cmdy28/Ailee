<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';

$sql2 = " select * from categorias";
$stmtex = $gbd->query($sql2);
$stmtex->execute();
$datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

$sql = " select * from clientes";
$stmtex2 = $gbd->query($sql);
$stmtex2->execute();
$clientes = $stmtex2->fetchAll(PDO::FETCH_ASSOC);

$sql = " select * from productos";
$stmtex1 = $gbd->query($sql);
$stmtex1->execute();
$productos = $stmtex1->fetchAll(PDO::FETCH_ASSOC);


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
                                <select class="form-control" data-placeholder="Buscar Cliente / Cédula" name="cliente"
                                    id="cliente">
                                    <option value=""></option>
                                    <?php
                                        foreach ($clientes as $client) {
                                            $clienteText = strtoupper($client['cedula'].' | '.$client['nombre']);
                                            echo '<option value='.$client['id'].'>'.$clienteText.'</option>';
                                        }
?>
                                    <!-- <option value="0">Nueva Categoría</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">#Documento</label>
                            <input type="text" placeholder="Doc.# 000-000-0000000000" disabled class="form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 div-filtro">
                            <form action="?modulo=menu" method="post">
                                <label for="nombre">Productos</label>
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
                            <!-- <form action="">
                            <label for="nombre">Filtrar por Categoría</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fa-solid fa-tag"></i></span>
                                    <select class="form-control" name="categoria" id="categoria">
                                        <option value="" disabled>--Selecciona una Categoría--</option>
                                        <option value="" >Todas</option>
                                        <?php
        foreach ($datos as $cate) {
            echo '<option value="'.$cate['id'].'">'.$cate['nombre'].'</option>';
        }
?>
                                    </select>

                                </div>
                            </form> -->
                            <br>
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
                        <button class="btn btn-guardar">Facturar</button>
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
                    <div>
                        <table class="table" id="tablaPedido">
                            <thead class="table-dark">
                                <tr>
                                    <th width="15%">Cant.</th>
                                    <th width="50%">Producto</th>
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


    <script>
    $('#cliente').select2();
    $('#producto').select2();

    //Cambia categoria
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
        //$("#tablaPedido>tbody").append("<tr><td>"+ cant +"</td><td>"+ nombre +"</td><td>"+ subtotal +"</td><th><button class='button-trash'><i class='fa-solid fa-xmark'></i></button></th></tr>");

        dataString = {
            'idProducto': idProducto,
            'cant': cant
        };
        $.ajax({
            url: "../subpages/pedidos/traer_productos.php",
            type: "POST",
            data: dataString,
            success: function(response) {
                $("#tablaPedido>tbody").append(response);
                calcularValores();
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
    }

    function eliminarFilaProducto(index) {
        $("#fila" + index).remove();
        calcularValores();
    }
    </script>
</body>

</html>