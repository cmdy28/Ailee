<?php

class Empleado
{
    public function traerEmpleados($gbd)
    {
        $sql2 = " select * from empleados order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerEmpleadosExcel($gbd)
    {
        $consulta = "select * from empleados order by nombre";
        $sentencia = $gbd->prepare($consulta, [
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
        ]);
        $sentencia->execute();

        return $sentencia;
    }

    public function traerEmpleado($gbd, $id)
    {
        $sql2 = " select * from empleados where id='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function buscarEmpleados($gbd, $search)
    {
        $sql2 = " select * from empleados where UPPER(nombre) like UPPER('%$search%') or cedula like '%$search%' or UPPER(email) like UPPER('%$search%')  order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function guardarEmpleado($gbd, $nombre, $cedula, $email, $direccion, $telefono)
    {
        $query = "insert into empleados (nombre, cedula, email, direccion, telefono) 
                values('$nombre', '$cedula', '$email', '$direccion', '$telefono') ";
        $insert = $gbd->prepare($query);
        $insert->execute();

        return $insert;
    }

    public function validaEmpleado($gbd, $email, $cedula)
    {
        $query = "select * from empleados where email=? or cedula=? ";
        $select = $gbd->prepare($query);
        $select->execute(array($email, $cedula));

        return $select;
    }

    public function actualizarEmpleado($gbd, $id, $nombre, $cedula, $email, $direccion, $telefono)
    {
        $query = "update empleados set nombre='$nombre', cedula='$cedula', email='$email', direccion='$direccion', telefono='$telefono' where id=$id";
        $update = $gbd->prepare($query);
        $update->execute();

        return $update;
    }
}
