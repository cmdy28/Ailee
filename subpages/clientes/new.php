<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
include '../class/clientes/cliente.class.php';

$clientes = new Cliente();

$input_id='';
$nombre = '';
$cedula = '';
$direccion = '';
$email = '';
$telefono = '';
$celular = '';
if (isset($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    $input_id='<input class="input" placeholder="" name="id" id="id" type="hidden" value="'.$id.'">';
    //Obtenemos los datos del cliente
    $datos=$clientes->traerCliente($gbd, $id);
    //var_dump($datos);
    $nombre = $datos['nombre'];
    $cedula = $datos['cedula'];
    $email = $datos['email'];
    $direccion = $datos['direccion'];
    $telefono = $datos['telefono'];
    $celular = $datos['celular'];
}
?>

<div class="container-fluid">
    <div id="respuesta"></div>
    <div class="div-new">
        <div>
            <a href="?modulo=clientes"><Button class="btn btn-regresar">Regresar</Button></a>
            <h5>Agregar / Editar Cliente</h5>
        </div>
        <hr>
        <form id="formCliente" action='../subpages/clientes/insert.php' name="formCliente" method="post">
            <?php echo $input_id; ?>
            <div class="row">
                <div class="col-md-4">
                    <label for="cedula">#Documento</label>
                    <div class="input-group flex-nowrap ">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-id-card"></i></span>
                        <input class="form-control" placeholder="#Documento" name="cedula" id="cedula" type="text"
                            value="<?php echo $cedula ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nombre">Nombre</label>
                    <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                        <input class="form-control" placeholder="Nombre" name="nombre" id="nombre" type="text"
                            value="<?php echo $nombre ?>">
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
                <div class="col-md-12">
                    <label for="direccion">Dirección</label>
                    <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-location-dot"></i></span>
                        <input class="form-control" placeholder="Dirección" name="direccion" id="direccion" type="text"
                            value="<?php echo $direccion ?>">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <label for="celular">Celular</label>
                    <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-phone"></i></span>
                        <input class="form-control" placeholder="Celular (5555551234)" name="celular" id="celular" type="text"
                            value="<?php echo $celular?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="telefono">Teléfono</label>
                    <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-phone"></i></span>
                        <input class="form-control" placeholder="Teléfono (00 000 0000)" name="telefono" id="telefono" type="text"
                            value="<?php echo $telefono ?>">
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
$('#formCliente').submit(function() { // catch the form's submit event
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