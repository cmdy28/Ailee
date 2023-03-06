<?php

class Factura
{
    public function traerFacturas($gbd)
    {
        $sql2 = " select * from facturas order by fecha";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerFacturasExcel($gbd)
    {
        $consulta = "select * from facturas order by fecha";
        $sentencia = $gbd->prepare($consulta, [
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
        ]);
        $sentencia->execute();

        return $sentencia;
    }

    public function traerFactura($gbd, $id)
    {
        $sql2 = " select * from facturas where id='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerPedidoFactura($gbd, $id)
    {
        $sql2 = " select * from detalle_pedido where factura='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    // public function buscarFacturas($gbd, $search)
    // {
    //     $sql2 = " select * from facturas where UPPER(cliente) like UPPER('%$search%') or cedula like '%$search%' or UPPER(email) like UPPER('%$search%')  order by nombre";
    //     $stmtex = $gbd->query($sql2);
    //     $stmtex->execute();
    //     $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

    //     return $datos;
    // }

    public function guardarFactura($gbd, $cliente, $subtotal, $iva, $total)
    {
        $query = "insert into facturas (cliente, subtotal, iva, total) 
                values($cliente, $subtotal, $iva, $total) RETURNING id";
        $insert = $gbd->prepare($query);
        $insert->execute();
        $insert = $insert->fetch(PDO::FETCH_ASSOC);

        return $insert;
    }
}
