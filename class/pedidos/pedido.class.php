<?php
class Pedido{
    public function traerPedidos($gbd)
    {
        $sql2 = " select * from pedidos";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerPedido($gbd, $id)
    {
        $sql2 = " select * from pedidos where id='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerDetallePedido($gbd, $id)
    {
        $sql2 = " select * from detalle_pedido where pedido='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerFacturaDetallePedido($gbd, $id)
    {
        $sql2 = " select factura from detalle_pedido where pedido='$id'";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function crearPedido($gbd)
    {
        $comentario = 'Pedido creado en '.date('F j, Y, g:i a');
        $query = "insert into pedidos (comentario) 
                values('$comentario') RETURNING id";
        $insert = $gbd->prepare($query);
        $insert->execute();
        $insert = $insert->fetch(PDO::FETCH_ASSOC);

        return $insert;
    }
    
    public function agregarDetallePedido($gbd, $pedido, $producto, $cant){
        $query = "insert into detalle_pedido (pedido, producto, cant)
                values($pedido, $producto, $cant)";
        $insert = $gbd->prepare($query);
        $insert->execute();

        return $insert;
    }

    public function compruebaDetallePedido($gbd, $pedido, $producto){
        $sql2 = " select * from detalle_pedido where pedido=$pedido and producto=$producto";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();

        return $stmtex;
    }

    public function actualizaDetallePedido($gbd, $pedido, $producto, $cant){
        $query = "update detalle_pedido set cant='$cant' where pedido=$pedido and producto=$producto";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }

    public function actualizaFacturaPedido($gbd, $pedido, $factura){
        $query = "update detalle_pedido set factura='$factura' where pedido=$pedido";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }

    public function agregaMesaPedido($gbd, $pedido, $mesa){
        $query = "insert into (pedido, mesa) values($mesa, $pedido)";
        $insert = $gbd->prepare($query);
        $insert->execute();
        return $insert;
    }

    public function actualizaMesa($gbd, $idmesa, $estado){
        $query = "update mesas set estado='$estado' where mesa=$idmesa";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }

    public function eliminarDetallePedido($gbd, $pedido, $producto){
        $query = "update detalle_pedido set estado=10 where pedido=$pedido and producto=$producto";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }
}


?>