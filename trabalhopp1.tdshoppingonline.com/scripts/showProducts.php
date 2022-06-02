<?php
    try{
        $name = $_GET["name"];
        require_once "connectionMysql.php";

        $conn = connectionToMySQL();
        $sql = "select idproduct, name, price, sold, quantity from tdproducts where offertitle like '%$name%';";
        $result = $conn->query($sql);
        if(!$result){
            throw new Exception("Erro na consulta dos produtos");
        }

       while($row = $result->fetch_assoc()){
            $id = $row["idproduct"];
            $name     = $row["name"];
            $price    = $row["price"];
            $sold     = $row["sold"];
            $quantity = $row["quantity"];
            echo "<tr>	<td>$id</td>  <td>$name</td><td><span id='soldTd'>$sold</span></td> <td>R$$price</td><td><span id='qtdTd'>$quantity</span></td> 
            <td><img onclick='redirectProduct($id)' id='seeProductIcon' 
            src='images/admin/product.png'></td><td><img src='images/admin/price.png' id='priceIcon' onclick='recordIdProduct($id, this)'
            data-toggle='modal' data-target='#modalPrice'></td><td><img 
            src='images/admin/stock.png' onclick='recordIdProduct($id, this)' id='stockIcon' data-toggle='modal' 
            data-target='#modalQtd'></td><td><img 
            src='images/admin/trash.png' onclick='recordIdProduct($id, this)' id='trashIcon' data-toggle='modal' 
            data-target='#removeProduct'></td></tr><tr>";
       }
        
    }catch(Exception $e){
        echo $e->getMessage();
    }finally{
        if($conn != null)
            $conn->close();
    }

?>