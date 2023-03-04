<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
include '../class/provision/proveedor.class.php';

$proveedores = new Proveedor();

$input_id='';
$nombre_comercial = $nombre_contacto = $ruc = $direccion = $email = $telefono = $celular = $observacion = '';

if (isset($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    $input_id='<input class="input" placeholder="" name="id" id="id" type="hidden" value="'.$id.'">';
    
    $datos=$proveedores->traerProveedor($gbd, $id);
    //var_dump($datos);
    $nombre_comercial = $datos['nombre_comercial'];
    $nombre_contacto = $datos['nombre_contacto'];
    $ruc = $datos['ruc'];
    $email = $datos['email'];
    $direccion = $datos['direccion'];
    $telefono = $datos['telefono'];
    $celular = $datos['celular'];
    $observacion = $datos['observacion'];
}
?>

<div class="container-fluid">
    <div id="respuesta"></div>
    <div class="div-new">
        <div>
            <a href="inicio.php?modulo=proveedores"><Button class="btn btn-regresar">Regresar</Button></a>
            <h5>Agregar / Editar Proveedor</h5>
        </div>
        <hr>
        <form id="formProveedor" action='../subpages/proveedores/insert.php' name="formProveedor" method="post">
            <?php echo $input_id; ?>
            <div class="row">
                <div class="col-md-4">
                    <label for="ruc">RUC</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-id-card"></i></span>
                        <input class="form-control" placeholder="RUC" name="ruc" id="ruc" type="text"
                            value="<?php echo $ruc ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <label for="nombre_comercial">Nombre Comercial</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-truck"></i></span>
                        <input class="form-control" placeholder="Proveedor (Nombre Comercial)" name="nombre_comercial"
                            id="nombre_comercial" type="text" value="<?php echo $nombre_comercial ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nombre_contacto">Nombre Contacto</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                        <input class="form-control" placeholder="Nombre de Contacto" name="nombre_contacto"
                            id="nombre_contacto" type="text" value="<?php echo $nombre_comercial ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-envelope"></i></span>
                        <input class="form-control" placeholder="Correo Electrónico" name="email" id="email" type="text"
                            value="<?php echo $email ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <label for="celular">Celular</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i
                                class="fa-solid fa-mobile-screen-button"></i></span>
                        <input class="form-control" placeholder="Celular" name="celular" id="celular" type="text"
                            value="<?php echo $celular ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="telefono">Teléfono</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-phone"></i></span>
                        <input class="form-control" placeholder="Teléfono" name="telefono" id="telefono" type="text"
                            value="<?php echo $telefono ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="direccion">Dirección</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i
                                class="fa-solid fa-location-dot"></i></span>
                        <input class="form-control" placeholder="Dirección" name="direccion" id="direccion" type="text"
                            value="<?php echo $direccion ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="observacion">Observación</label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-eye"></i></span>
                        <textarea class="form-control" placeholder="Observacion" name="observacion" id="observacion"
                            cols="30" rows="3">
                    <?php echo $observacion ?>
                    </textarea>
                    </div>
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


<!-- enviar formulario -->
<script type="text/javascript">
$('#formProveedor').submit(function() { // catch the form's submit event
    $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            console.log(response);
            $('#respuesta').html(response);
        },
        error: function(response) {
            $('#respuesta').html(response);
        }
    });

    return false; // cancel original event to prevent form submitting
});
</script>