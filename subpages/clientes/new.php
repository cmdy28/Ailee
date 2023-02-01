<div class="container-fluid">
    <div class="div-new">
        <div>
            <a href="?modulo=clientes"><Button class="btn btn-regresar">Regresar</Button></a>
            <h5>Agregar / Editar Cliente</h5>
        </div>
        <br>
        <hr>
        <br>
        <form action="/operaciones/insert.php" id="formCliente" method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="#Documento" name="cedula" id="cedula" type="text">
                        <span class="input-border"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Nombre" name="nombre" id="nombre" type="text">
                        <span class="input-border"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Correo Electrónico" name="email" id="email" type="email">
                        <span class="input-border"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-input">
                        <input class="input" placeholder="Dirección" name="direccion" id="direccion" type="text">
                        <span class="input-border"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Teléfono" name="telefono" id="telefono" type="text">
                        <span class="input-border"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-input">
                        <input class="input" placeholder="Celular" name="celular" id="celular" type="text">
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
<script>
      $('#formCliente').submit(function() { // catch the form's submit event
        $.ajax({ // create an AJAX call...
            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: $(this).attr('action'), // the file to call
            success: function(response) { // on success..
                showAlert('success', response);
            },
            
            error: function (response){
              showAlert('danger', response);
            }
        });

        return false; // cancel original event to prevent form submitting
    });

</script>