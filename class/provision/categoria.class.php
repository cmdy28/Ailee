<?php

class Categoria
{
    public function traerCategorias($gbd)
    {
        $sql2 = " select * from categorias order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }


    public function guardarCategoria($gbd, $nombre, $color)
    {
        $query = "insert into categorias (nombre, color) 
                values('$nombre', '$color') ";
        $insert = $gbd->prepare($query);
        $insert->execute();

        return $insert;
    }

    public function validaCategoria($gbd, $nombre)
    {
        $query = "select * from categorias where nombre=? ";
    $select = $gbd->prepare($query);
    $select->execute(array($nombre));

        return $select;
    }
}
