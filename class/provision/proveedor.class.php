<?php

class Proveedor
{
    public function traerProveedores($gbd)
    {
        $sql2 = " select * from proveedores order by nombre_comercial";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerProveedoresExcel($gbd)
    {
        $consulta = "select * from proveedores order by nombre_comercial";
        $sentencia = $gbd->prepare($consulta, [
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
        ]);
        $sentencia->execute();

        return $sentencia;
    }

    public function traerProveedor($gbd, $id)
    {
        $sql2 = " select * from proveedores where id='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function buscarProveedores($gbd, $search)
    {
        $sql2 = " select * from proveedores where UPPER(nombre_comercial) like UPPER('%$search%') or ruc like '%$search%' or UPPER(email) like UPPER('%$search%') order by nombre_comercial ";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function guardarProveedor($gbd, $nombre_comercial, $nombre_contacto, $ruc, $email, $direccion, $telefono, $celular, $observacion)
    {
        $query = "insert into proveedores (nombre_comercial, nombre_contacto, ruc, email, direccion, telefono, celular, observacion) 
                values('$nombre_comercial', '$nombre_contacto', '$ruc', '$email', '$direccion', '$telefono', '$celular', '$observacion') ";
        $insert = $gbd->prepare($query);
        $insert->execute();

        return $insert;
    }

    public function validaProveedor($gbd, $email, $ruc)
    {
        $query = "select * from proveedores where email=? or ruc=? ";
        $select = $gbd->prepare($query);
        $select->execute(array($email, $ruc));

        return $select;
    }

    public function actualizarProveedor($gbd, $id, $nombre_comercial, $nombre_contacto, $ruc, $email, $direccion, $telefono, $celular, $observacion)
    {
        $query = "update proveedores set nombre_comercial='$nombre_comercial', nombre_contacto='$nombre_contacto', ruc='$ruc', email='$email', direccion='$direccion', telefono='$telefono', celular='$celular', observacion='$observacion' where id=$id";
        $update = $gbd->prepare($query);
        $update->execute();

        return $update;
    }
}
