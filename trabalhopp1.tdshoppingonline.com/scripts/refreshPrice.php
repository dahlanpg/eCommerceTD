<?php
try{
    if(!isset($_GET["idProduct"], $_GET["newPrice"]))
        throw new Exception("Campo inválido");
    $idProduct = $_GET["idProduct"];
    $newPrice = $_GET["newPrice"];
    if(!is_numeric($newPrice))
        throw new Exception("Digite um preço válido");
    require_once "connectionMysql.php";
    $conn = connectionToMySQL();
    $conn->begin_transaction();
    $newPrice = floatval($newPrice);
    $oldPrice = 0.0;
    $sql = "select price from tdproducts where idproduct = $idProduct;";
    $result = $conn->query($sql);
    if(!$result)
        throw new Exception("Erro ao resgatar preço do produto");
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $oldPrice = $row["price"]; //o preço que estava na tabela passa a ser o antigo
        $oldPrice = floatval($oldPrice);
    }
    else
        throw new Exception("O produto requerido nao existe");
    if($oldPrice < $newPrice)
        $sql = "update tdproducts set price = $newPrice, oldprice = null where idproduct = $idProduct;";
    else
        $sql = "update tdproducts set price = $newPrice, oldprice = $oldPrice where idproduct = $idProduct;";
    if(!$conn->query($sql)){
        throw new Exception("Erro ao atualizar preço do produto");
    }
    $conn->commit();
    echo "ok";
}catch(Exception $e){
    $conn->rollback();
    echo $e->getMessage();
}finally{
    if($conn != null)
        $conn->close();
}





?>