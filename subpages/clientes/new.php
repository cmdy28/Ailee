<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';

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
    $sql2 = " select * from clientes where id='$id'";
    $stmtex = $gbd->query($sql2);
    $stmtex->execute();
    $datos = $stmtex->fetch(PDO::FETCH_ASSOC);
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
        <br>
        <hr>
        <br>
        <form id="formCliente" name="formCliente" method="post">
            <?php echo $input_id; ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="#Documento" name="cedula" id="cedula" type="text"
                            value="<?php echo $cedula ?>">
                        <span class="input-border"></span>
                        <span class="error" id="cedula_e"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Nombre" name="nombre" id="nombre" type="text"
                            value="<?php echo $nombre ?>">
                        <span class="input-border"></span>
                        <span class="error" id="nombre_e"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Correo Electrónico" name="email" id="email" type="email"
                            value="<?php echo $email ?>">
                        <span class="input-border"></span>
                        <span class="error" id="email_e"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-input">
                        <input class="input" placeholder="Dirección" name="direccion" id="direccion" type="text"
                            value="<?php echo $direccion ?>">
                        <span class="input-border"></span>
                        <span class="error" id="direccion_e"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Teléfono" name="telefono" id="telefono" type="text"
                            value="<?php echo $telefono ?>">
                        <span class="input-border"></span>
                        <span class="error" id="telefono_e"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Teléfono Secundario (Opcional)" name="celular" id="celular" type="text"
                            value="<?php echo $celular?>">
                        <span class="input-border"></span>
                    </div>
                </div>
            </div>
            <br>
            <hr>
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
        url: '../subpages/clientes/insert.php', // the file to call
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