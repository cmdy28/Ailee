<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../class/conexion.php';
//Obtenemos los datos del cliente
if (isset($_REQUEST['search'])) {
    $search = $_REQUEST['search'];
    $sql2 = " select * from clientes where UPPER(nombre) like UPPER('%$search%') 
    or cedula like '%$search%' or UPPER(email) like UPPER('%$search%')  order by nombre";
    $stmtex = $gbd->query($sql2);
    $stmtex->execute();
    $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql2 = " select * from clientes order by nombre";
    $stmtex = $gbd->query($sql2);
    $stmtex->execute();
    $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);
}

?>
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
                    <form action="?modulo=clientes" method="post" class="form">
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
                        <input class="input" placeholder="Buscar Cliente / Cédula / Email" name="search" id="search" type="text">
                    </form>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-icon" ><i class="fa-solid fa-file-excel" style="font-size:27px; color:#000"></i></button>
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
                        <th scope="col" width=15%>Teléfono(s)</th>
                        <th scope="col" width=10% style="text-align:center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($datos as $data){
                        echo '<tr>
                        <th scope="row">'.$data['cedula'].'</th>
                        <td>'.$data['nombre'].'</td>
                        <td>'.$data['email'].'</td>
                        <td>
                            <li>'.$data['telefono'].'</li>
                            <li>'.$data['celular'].'</li>
                        </td>
                        <td style="text-align:center">
                            <a href="?modulo=nuevocliente&id='.$data['id'].'">
                                <button class="btn btn-edit">
                                    <i class="fa-solid fa-pen" style="font-size:18px; color:#000"></i>
                                </button>
                            </a>
                        </td>
                    </tr>';
                    }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>