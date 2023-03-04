<?php

class Cliente
{
    public function traerClientes($gbd)
    {
        $sql2 = " select * from clientes order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerClientesExcel($gbd)
    {
        $consulta = "select * from clientes";
        $sentencia = $gbd->prepare($consulta, [
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
        ]);
        $sentencia->execute();

        return $sentencia;
    }

    public function traerCliente($gbd, $id)
    {
        $sql2 = " select * from clientes where id='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function buscarClientes($gbd, $search)
    {
        $sql2 = " select * from clientes where UPPER(nombre) like UPPER('%$search%') or cedula like '%$search%' or UPPER(email) like UPPER('%$search%')  order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function guardarCliente($gbd, $nombre, $cedula, $email, $direccion, $telefono, $celular)
    {
        $query = "insert into clientes (nombre, cedula, email, direccion, telefono, celular) 
                values('$nombre', '$cedula', '$email', '$direccion', '$telefono', '$celular') ";
        $insert = $gbd->prepare($query);
        $insert->execute();

        return $insert;
    }

    public function validaCliente($gbd, $email, $cedula)
    {
        $query = "select * from clientes where email=? or cedula=? ";
        $select = $gbd->prepare($query);
        $select->execute(array($email, $cedula));

        return $select;
    }

    public function actualizarCliente($gbd, $id, $nombre, $cedula, $email, $direccion, $telefono, $celular)
    {
        $query = "update clientes set nombre='$nombre', cedula='$cedula', email='$email', direccion='$direccion', telefono='$telefono', celular='$celular' where id=$id";
        $update = $gbd->prepare($query);
        $update->execute();

        return $update;
    }
}



?>
