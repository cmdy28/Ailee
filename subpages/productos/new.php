<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
include '../class/provision/producto.class.php';
include '../class/provision/categoria.class.php';
$productos = new Producto();
$categorias = new Categoria();

$categorias = $categorias->traerCategorias($gbd);
//var_dump($categorias);

$input_id='';
$nombre = '';
$codigo = '';
$precio_sin_iva = '';
$precio_con_iva = '';
$impuesto_iva = '';
$impuesto_servicio = '';
$descripcion = '';
$estado = '';
$color = '';
$es_materia_prima = '';
$incluir_en_menu = '';
$categoria = '';
if (isset($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    $input_id='<input class="input" placeholder="" name="id" id="id" type="hidden" value="'.$id.'">';
    //Obtenemos los productos
    $datos=$productos->traerProducto($gbd, $id);
    //var_dump($datos);
    $nombre = $datos['nombre'];
    $codigo = $datos['codigo'];
    $precio_con_iva = $datos['precio_con_iva'];
    $precio_sin_iva = $datos['precio_sin_iva'];
    $impuesto_iva = $datos['impuesto_iva'];
    $impuesto_servicio = $datos['impuesto_servicio'];
    $descripcion = $datos['descripcion'];
    $estado = $datos['estado']; //3 -> activo
    $color = $datos['color'];
    $es_materia_prima = $datos['es_materia_prima'];
    $incluir_en_menu = $datos['incluir_en_menu']; //1->true
    $categoria = $datos['categoria'];
}
?>

<div class="container-fluid">
    <div id="respuesta1"></div>
    <div class="div-new">
        <div>
            <a href="?modulo=productos"><Button class="btn btn-regresar">Regresar</Button></a>
            <h5>Agregar / Editar Producto</h5>
        </div>
        <hr>
        <form id="formProducto" action='../subpages/productos/insert.php' name="formProducto" method="post">
            <?php echo $input_id; ?>
            <div class="row">
                <div class="col-md-4">
                    <label for="codigo">Código</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-bookmark"></i></span>
                        <input class="form-control" placeholder="Código" name="codigo" id="codigo" type="text"
                            value="<?php echo $codigo ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nombre">Nombre</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-box"></i></span>
                        <input class="form-control" placeholder="Nombre" name="nombre" id="nombre" type="text"
                            value="<?php echo $nombre ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="precio_con_iva">Categoría</label>
                    <div class="input-group flex-nowrap" id="listcategoria">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-tag"></i></span>
                        <select class="form-control" name="categoria" id="categoria" onchange="nuevaCategoria()">
                            <option value="">--Selecciona una categoria--</option>
                            <?php
                            foreach ($categorias as $cate) {
                                if($cate['id'] == $categoria){
                                    echo '<option value='.$cate['id'].' selected>'.$cate['nombre'].'</option>';
                                }
                                echo '<option value='.$cate['id'].'>'.$cate['nombre'].'</option>';
                            }
?>
                            <option value="0">Nueva Categoría</option>
                        </select>

                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8">
                    <label for="descripcion">Descripción</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"></span>
                        <textarea class="form-control" placeholder="descripcion" name="descripcion" id="descripcion"
                            cols="30" rows="4">
                    <?php echo $descripcion ?>
                    </textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="precio_sin_iva">Precio sin IVA</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i
                                class="fa-solid fa-hand-holding-dollar"></i></span>
                        <input class="form-control" placeholder="0.00" name="precio_sin_iva" id="precio_sin_iva"
                            type="text" step="any" value="<?php echo $precio_sin_iva ?>">
                    </div>
                    <label for="precio_con_iva">Precio con IVA</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i
                                class="fa-solid fa-hand-holding-dollar"></i></span>
                        <input class="form-control" placeholder="0.00" name="precio_con_iva" id="precio_con_iva"
                            type="text" step="any" value="<?php echo $precio_con_iva ?>">
                    </div>
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <label for="">Otras opciones</label>
                    <div class="input-group flex-nowrap">
                        <?php
                        if($es_materia_prima == 1){
                            echo '<input type="checkbox" name="es_materia_prima" id="es_materia_prima" checked class="checkbox-input">';
                        }
                        else{
                            echo '<input type="checkbox" name="es_materia_prima" id="es_materia_prima" class="checkbox-input">';
                        }
                        ?>
                        <!-- <input type="checkbox" name="es_materia_prima" id="es_materia_prima" class="checkbox-input"> -->
                        <span class="span-checkbox"> ¿Es Materia Prima?</span>
                    </div>
                    <div class="input-group flex-nowrap">
                    <?php
                        if($incluir_en_menu == 1){
                            echo '<input type="checkbox" name="en_el_menu" id="en_el_menu" class="checkbox-input" checked> ';
                        }
                        else{
                            echo '<input type="checkbox" name="en_el_menu" id="en_el_menu" class="checkbox-input"> ';
                        }
                        ?>
                        <!-- <input type="checkbox" name="en_el_menu" id="en_el_menu" class="checkbox-input">  -->
                        <span class="span-checkbox"> ¿En el Menú?</span>
                    </div>
                    <div class="input-group flex-nowrap">
                    <?php
                        if($estado == 3){
                            echo '<input type="checkbox" name="estado" id="estado" class="checkbox-input" checked>';
                        }
                        else{
                            echo '<input type="checkbox" name="estado" id="estado" class="checkbox-input"> ';
                        }
                        ?>
                        <!-- <input type="checkbox" name="estado" id="estado" class="checkbox-input">  -->
                        <span class="span-checkbox"> Estado</span>
                    </div>
                    <!-- <div class="input-group flex-nowrap">
                            <input type="checkbox" name="" id=""> <label for=""> En el Menú</label> 
                    </div> -->
                </div>
                <div class="col-md-2">
                    <label for="">Impuestos</label>
                    <div class="input-group flex-nowrap">
                    <?php
                        if($impuesto_iva == 1){
                            echo '<input type="checkbox" name="impuesto_iva" id="impuesto_iva" class="checkbox-input" checked>';
                        }
                        else{
                            echo '<input type="checkbox" name="impuesto_iva" id="impuesto_iva" class="checkbox-input">';
                        }
                        ?>
                        <!-- <input type="checkbox" name="impuesto_iva" id="impuesto_iva" class="checkbox-input"> -->
                        <span class="span-checkbox"> IVA(12%)</span>
                    </div>
                    <div class="input-group flex-nowrap">
                    <?php
                        if($impuesto_servicio == 1){
                            echo '<input type="checkbox" name="impuesto_servicio" id="impuesto_servicio" class="checkbox-input" checked>';
                        }
                        else{
                            echo '<input type="checkbox" name="impuesto_servicio" id="impuesto_servicio" class="checkbox-input">';
                        }
                        ?>
                        <!-- <input type="checkbox" name="impuesto_servicio" id="impuesto_servicio" class="checkbox-input">  -->
                        <span class="span-checkbox">Servicio (10%)</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="">Selecciona el color del Producto</label>
                    <input class="form-control" type="color" name="color" id="color" value="<?php echo $color ?>">
                </div>
            </div>
            <br>
            <br>
            <div>
                <button type="submit" class="btn btn-guardar">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Button trigger modal -->
<button id="abreModalCategoria" hidden type="button" class="btn btn-primary" data-bs-toggle="modal"
    data-bs-target="#categoriaModal">
    Launch demo modal
</button>

<!-- Modal Nueva Categoría-->
<div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Categoría</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="respuesta"></div>
                <form action="../subpages/productos/insert_categoria.php" method="post" id="categoriaForm">
                    <div>
                        <label for="categoria_new">Nombre Categoría</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-tag"></i></span>
                            <input class="form-control" placeholder="" name="categoria_new" id="categoria_new"
                                type="text">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                    <div class="col-md-6">
                        <label for="">Selecciona el color de la categoría</label>
                    </div>
                    <div class="col-md-2">
                        <input class="form-control" type="color" name="color" id="color">
                    </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-regresar" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-guardar" >Guardar</button>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div> -->
        </div>
    </div>
</div>



<!-- enviar formulario -->
<script type="text/javascript">
//$('#categoria').select2();
$('#formProducto').submit(function() { // catch the form's submit event
    $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            console.log(response);
            $('#respuesta1').html(response);
        },
        error: function(response) {
            $('#respuesta1').html(response);
        }
    });

    return false; // cancel original event to prevent form submitting
});

$('#categoriaForm').submit(function() { // catch the form's submit event
    $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            console.log(response);
            var comprobar = response.includes("agrego");
                if (comprobar == true) {
                    $('#categoriaModal').modal('hide');
                    $('#respuesta1').html(response);
                    $("#listcategoria").load(location.href + " #listcategoria");
                    var form = document.getElementById('categoriaForm');
                    form.reset();
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


function nuevaCategoria() {
    var option_value = document.getElementById("categoria").value;
    console.log(option_value);
    if (option_value == "0") {
        console.log('entra en condicional');
        //$('#abreModalCategoria').click();
        $("#categoriaModal").modal("show");
    }
}

let precio_iva = document.querySelector('#precio_con_iva');
let precio_sin_iva = document.querySelector('#precio_sin_iva');

precio_iva.addEventListener('keyup',()=>{
    val_precio_iva = parseFloat(precio_iva.value);
    iva = parseFloat(0.12);
    val_iva = val_precio_iva * iva;
    real = val_precio_iva - val_iva;
    precio_sin_iva.value = parseFloat(real.toFixed(2));
});

precio_sin_iva.addEventListener('keyup',()=>{
    val_precio_sin_iva = parseFloat(precio_sin_iva.value);
    iva = parseFloat(0.12);
    val_iva = val_precio_sin_iva * iva;
    real = val_precio_sin_iva + val_iva;
    precio_iva.value = parseFloat(real.toFixed(2));
});


</script>