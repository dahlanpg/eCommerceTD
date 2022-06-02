<?php
    require_once "connectionMysql.php";
    require_once "orders.php";
    $idOrder = $_GET["idOrder"];
    try{   
     $conn = connectionToMySQL();
     $orderXproduct = productsOrder($conn, $idOrder);
     for($i = 0; $i < sizeof($orderXproduct); ++$i){
        $name = $orderXproduct[$i]->productName;
        $qtd = $orderXproduct[$i]->quantity;
        echo "<div class='row' style='margin-top: 2%;''>
                <div class='col-5'>$name</div>
                <div class='col-3'></div>
                <div class='col-4'>$qtd</div>
             </div>";
     }
    }catch(Exception $e){
        echo $e->getMessage();
    }

?>