<?php
try{
    require_once "connectionMysql.php";
    require_once "orders.php";

    $conn = connectionToMySQL();
    $orders = allOrders($conn);

    for ($i = 0; $i < sizeof($orders); ++$i) {
        $idOrder = $orders[$i]->idOrder;
        $date = explode(' ', $orders[$i]->date);
        $timetable = $date[1];
        $date = $date[0];
        $date = implode('/', array_reverse(explode('-', $date)));

        $totalValue = $orders[$i]->totalValue;
        $idOrder = $orders[$i]->idOrder;
        $paymentMethod = $orders[$i]->paymentMethod;

        echo "<tr>
        <td>$idOrder</td>
        <td>$date $timetable</td>
        <td>$totalValue</td>
        <td>$paymentMethod</td>
        <td><a data-toggle='modal' data-target='#detailsModal' onclick='detailsWish($idOrder)'><img src='images/admin/product-description2.png' class='wishDetailsImg'></a></td>
        </tr>";
    }
}catch(Exception $e){
    echo $e->getMessage();
}finally{
    if(isset($conn))
        $conn->close();
}
?>