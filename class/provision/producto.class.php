<?php

class Producto
{
    public function traerProductos($gbd)
    {
        $sql2 = " select * from productos order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }


    public function traerProductosExcel($gbd)
    {
        $consulta = "select * from productos order by nombre";
        $sentencia = $gbd->prepare($consulta, [
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
        ]);
        $sentencia->execute();

        return $sentencia;
    }

    public function traerProducto($gbd, $id)
    {
        $sql2 = " select * from productos where id='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function buscarProductos($gbd, $search)
    {
        $sql2 = " select * from productos where UPPER(nombre) like UPPER('%$search%') or codigo like UPPER('%$search%') order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function guardarProducto($gbd, $nombre, $categoria, $codigo, $descripcion, $precio_sin_iva, $precio_con_iva, $es_materia_prima, $en_el_menu, $estado, $impuesto_iva, $impuesto_servicio, $color)
    {
        $query = "insert into productos (nombre, categoria, codigo, descripcion, precio_sin_iva, precio_con_iva, es_materia_prima, incluir_en_menu, estado, impuesto_iva, impuesto_servicio, color) 
                values('$nombre', $categoria, '$codigo', '$descripcion', $precio_sin_iva, $precio_con_iva, $es_materia_prima, $en_el_menu, $estado, $impuesto_iva, $impuesto_servicio, '$color') ";
        $insert = $gbd->prepare($query);
        $insert->execute();

        return $insert;
    }

    public function validaProducto($gbd, $codigo, $nombre)
    {
        $query = "select * from productos where codigo=? or nombre=? ";
        $select = $gbd->prepare($query);
        $select->execute(array($codigo, $nombre));

        return $select;
    }

    public function actualizarProducto($gbd, $id, $nombre, $categoria, $codigo, $descripcion, $precio_sin_iva, $precio_con_iva, $es_materia_prima, $en_el_menu, $estado, $impuesto_iva, $impuesto_servicio, $color)
    {
        $query = "update productos set nombre='$nombre', categoria='$categoria', codigo='$codigo', descripcion='$descripcion', 
        precio_sin_iva='$precio_sin_iva', precio_con_iva='$precio_con_iva', es_materia_prima=$es_materia_prima, incluir_en_menu=$en_el_menu, 
        estado=$estado, impuesto_iva=$impuesto_iva, impuesto_servicio=$impuesto_servicio, color='$color' where id=$id";
        $update = $gbd->prepare($query);
        $update->execute();

        return $update;
    }
}
