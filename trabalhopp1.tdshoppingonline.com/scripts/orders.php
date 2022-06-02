<?php
class Order{
	public $idOrder;
	public $idClient;
	public $totalValue;
	public $status;
    public $date;
    public $paymentMethod;
    public $orderXProducts = [];
}

class OrderXProducts{
    public $productId;
    public $productName;
    public $quantity;
    public $finalvalue;
}

    function myOrders($idUser, $conn){
        try{
            $arrayOrders = [];
            $sql = "SELECT id_order, totalvalue, paymentMethod,created_at from tdorders where iduser = $idUser;";
            $result = $conn->query($sql);
            if(!$result){
                throw new Exception("Erro ao verificar pedidos, tente novamente");
            }
            while ($row = $result->fetch_assoc()){
                $order = new Order();
                $order->idClient              = $idUser;
                $order->idOrder               = $row["id_order"];
                $order->totalvalue            = $row["totalvalue"];
                $order->date                  = $row["created_at"];
                $order->paymentMethod         = $row["paymentMethod"];

                $sql2 = "SELECT P.name, OP.quantity, OP.finalValue, OP.idproduct 
                    from tdproducts as P,tdorders_products as OP where OP.idproduct 
                    = P.idproduct and OP.idorders = $order->idOrder;";
                $result2 = $conn->query($sql2);
                if(!$result2){
                    throw new Exception("Erro ao verificar pedidos, tente novamente");
                }
                while ($row2 = $result2->fetch_assoc()){
                    $orderXproduct = new OrderXProducts();
                    $orderXproduct->productId               = $row2["idproduct"];
                    $orderXproduct->productName             = $row2["name"];
                    $orderXproduct->quantity                = $row2["quantity"];
                    $orderXproduct->finalvalue              = $row2["finalValue"];
                    $order->orderXProducts[] = $orderXproduct;
                }

                $arrayOrders[] = $order;
         }
        
        return $arrayOrders;
         
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function allOrders($conn){
        $sql = "select * from tdorders;";
        $arrayOrders = [];
        $result = $conn->query($sql);
        if(!$result){
            throw new Exception("Erro ao resgatar pedidos");
        }

        while($row = $result->fetch_assoc()){
            $order = new Order();
            $order->idOrder                 = $row["id_order"];
            $order->totalvalue              = $row["totalvalue"];
            $order->date                    = $row["created_at"];
            $order->totalValue              = $row["totalvalue"];
            $order->paymentMethod           = $row["paymentMethod"];
           $arrayOrders[] = $order;
        }

        return $arrayOrders;
    }

    function productsOrder($conn, $idorder){
        $sql = "SELECT P.name, OP.quantity, OP.idproduct 
                from tdproducts as P,tdorders_products as OP where OP.idproduct 
                = P.idproduct and OP.idorders = $idorder;";
        $result = $conn->query($sql);
        if(!$result){
            throw new Exception("Erro ao verificar pedidos, tente novamente");
        }
        $orderX = [];
        while ($row2 = $result->fetch_assoc()){
            $orderXproduct = new OrderXProducts();
            $orderXproduct->productId               = $row2["idproduct"];
            $orderXproduct->productName             = $row2["name"];
            $orderXproduct->quantity                = $row2["quantity"];
            $orderX[] = $orderXproduct;
        }

        return $orderX;
    }
?>