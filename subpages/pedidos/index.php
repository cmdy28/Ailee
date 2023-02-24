<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';

$sql2 = " select * from categorias";
$stmtex = $gbd->query($sql2);
$stmtex->execute();
$datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

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
                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                <input class="form-control" placeholder="Buscar Producto / Código" name="nombre"
                                    id="nombre" type="text">
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
                                    <input class="form-control" placeholder="Buscar Producto / Código" name="nombre"
                                        id="nombre" type="text">
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
                            <label for="categoria">Filtrar por Categoría</label>
                            <hr>
                            <div class="div-categorias">
                                <?php
foreach ($datos as $cate) {
    echo '<a class="link-categoria" href="?modulo=menu&categoria='.$cate['id'].'"><div class="container-link-categoria" style="background-color:'.$cate['color'].'">'.$cate['nombre'].'</div></a>';
}
?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="container-productos">
                                <div class="row">
                                    <?php
                            foreach ($productos as $product) {
                                echo '<div class="col-md-2 col-product">
                                <button class="btn-product">
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
                        <h3 class="text-light">$ 0</h3>
                        <button class="btn btn-guardar">Facturar</button>
                        <br>
                        <br>
                    </div>
                    <div class="div-subtotal">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="subtotal-iva">Subtotal</span>
                                <p class="valor-precio">$0</p>
                            </div>
                            <div class="col-md-6">
                                <span class="subtotal-iva">IVA (12%)</span>
                                <p class="valor-precio">$0</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Cant.</th>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                    <th><i class="fa-solid fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><button class="button-trash"><i class="fa-solid fa-xmark"></i></button></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>