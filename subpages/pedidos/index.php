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
                            <input type="text" placeholder="Buscar Cliente" class="form-control">
                        </div>
                        <div class="col-md-4">
                        <label for="" class="form-label">#Documento</label>
                            <input type="text" placeholder="Doc.# 000-000-0000000000" disabled class="form-control">
                        </div>
                    </div>
                    <div>
                    <div>
                            <label for="" class="form-label">Producto</label>
                            <input type="text" placeholder="Buscar Producto" class="form-control">
                        </div>
                    </div>
                    <hr>
                    <nav>
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <button class="nav-link nav-tab active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">Home</button>
                            <button class="nav-link nav-tab" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="false">Profile</button>
                            <button class="nav-link nav-tab" id="nav-contact-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                                aria-selected="false">Contact</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab" tabindex="0">UNO</div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                            tabindex="0">DOS</div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                            tabindex="0">TRES</div>
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