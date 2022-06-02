<?php
    session_start();
    $idClient = $_SESSION["id"];
    require_once "orders.php";
    require_once "connectionMysql.php";
    try{
        $conn = connectionToMySQL();
        $orders = myOrders($idClient, $conn);
        for($i = 0; $i < sizeof($orders); ++$i){
            echo "<div class='row'>
            <div class='col-2 ordersPart1'>
                <img class='productCart' src='images/myAccount/shopping-bag.png'>
            </div>
            <div class='col-3 ordersPart2'>
            ";
            
            for($j = 0 ; $j < sizeof($orders[$i]->orderXProducts) ; ++$j){
                $name = $orders[$i]->orderXProducts[$j]->productName;
                $qtd  = $orders[$i]->orderXProducts[$j]->quantity;
                echo "
                    <p><span class='amount'>$qtd" . "x</span> $name</p>";
            }
            $date = explode(' ', $orders[$i]->date);
            $timetable = $date[1];
            $date = $date[0];
            $date = implode('/', array_reverse(explode('-', $date)));
            $totalValue = $orders[$i]->totalvalue;
            echo "
                </div>
                <div class='col-2 ordersPart3'>

                </div>
                <div class='col-3 ordersPart4'>
                    <p class='date'>$date $timetable</p>
                </div>
                <div class='col-2 ordersPart5'>
                    <p class='totalValue'>R$$totalValue</p>
                </div>
            </div>";   
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
?>