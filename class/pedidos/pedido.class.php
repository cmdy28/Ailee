<?php
//PEDIDOS, MESAS, DETALLE_PEDIDO, PEDIDO_FACTURA
class Pedido{

    //Pedidos
    public function traerPedidos($gbd)
    {
        $sql2 = " select * from pedidos";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerPedidosEstado($gbd, $estado)
    {
        $sql2 = " select * from pedidos where estado=$estado";
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
    
    public function actualizaPedidoEstado($gbd, $pedido, $estado){
        $query = "update pedidos set estado=$estado where id=$pedido";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }
    //detallePedido
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

    public function traerDetallePedido($gbd, $id)
    {
        $sql2 = " select * from detalle_pedido where pedido='$id' and estado=9";
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

    public function eliminarDetallePedido($gbd, $pedido, $producto){
        $query = "update detalle_pedido set estado=10 where pedido=$pedido and producto=$producto";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }

    //facturaPedido
    public function actualizaFacturaPedido($gbd, $pedido, $factura){
        $query = "update detalle_pedido set factura='$factura' where pedido=$pedido";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }

    //mesaPedido
    public function traerMesaPedidos($gbd){
        $sql2 = " select * from mesa_pedido";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerMesaPedido($gbd, $pedido){
        $sql2 = " select * from mesa_pedido where pedido=$pedido";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();

        return $stmtex;
    }

    public function agregaMesaPedido($gbd, $pedido, $mesa){
        $query = "insert into mesa_pedido (mesa, pedido) values($mesa, $pedido)";
        $insert = $gbd->prepare($query);
        $insert->execute();
        return $insert;
    }

    //Mesas
    public function traerMesas($gbd){
        $sql2 = " select * from mesas order by nombre";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function traerMesa($gbd, $idmesa){
        $sql2 = " select * from mesas where id=$idmesa";
        $stmtex = $gbd->query($sql2);
        $stmtex->execute();
        $datos = $stmtex->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }
    
    public function comprobarMesa($gbd, $mesa){
        $query = "select estado from mesas where id=$mesa";
        $comprueba = $gbd->prepare($query);
        $comprueba->execute();
        $comprueba = $comprueba->fetch(PDO::FETCH_ASSOC);

        return $comprueba;
    }

    public function actualizaMesa($gbd, $idmesa, $estado){
        $query = "update mesas set estado=$estado where id=$idmesa";
        $update = $gbd->prepare($query);
        $update->execute();
        return $update;
    }

}


?>