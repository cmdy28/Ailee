<div class="container-fluid">
    <div class="div-new">
        <div>
            <a href="#"><Button class="btn btn-nuevo">Importar</Button></a>
            <a href="?modulo=nuevocliente"><Button class="btn btn-nuevo">Nuevo Cliente</Button></a>
            <h5>Clientes</h5>
        </div>
        <hr>
        <div>
            <div class="row">
                <div class="col-md-5">
                    <form action="" class="form">
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
                        <input class="input" placeholder="Buscar" required="" type="text">
                    </form>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-icon"><i class="fa-solid fa-file-excel" style="font-size:27px; color:#000"></i></button>
                    <button class="btn btn-icon"><i class="fa-solid fa-file-pdf" style="font-size:27px; color:#000"></i></button>
                </div>
            </div>
        </div>
        <br>
        <div>
            <table class="table">
                <thead class="bg-light-table">
                    <tr>
                        <th scope="col" width=15%># Documento</th>
                        <th scope="col" width=30%>Cliente</th>
                        <th scope="col" width=30%>Email</th>
                        <th scope="col" width=15%>Teléfono</th>
                        <th scope="col" width=10% style="text-align:center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td style="text-align:center">
                            <a href="?modulo=nuevocliente?id=0">
                                <button class="btn btn-edit">
                                    <i class="fa-solid fa-pen" style="font-size:18px; color:#000"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>