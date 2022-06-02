<?php
    try{
        if(!isset($_GET["idProduct"], $_GET["newStock"]))
             throw new Exception("Campo inválido");
        require_once "connectionMysql.php";
        $idProduct = $_GET["idProduct"];
        $newStock = $_GET["newStock"];
        if(!is_numeric($newStock))
            throw new Exception("Digite um número válido");
        $conn = connectionToMySQL();
        $newStock = intval($newStock);
        $sql = "update tdproducts set quantity = $newStock where idproduct = $idProduct;";
        if(!$conn->query($sql)){
            throw new Exception("Erro ao atualizar estoque do produto");
        }
        echo "ok";
    }catch(Exception $e){
        echo $e->getMessage();
    }finally{
        if(isset($conn))
            $conn->close();
    }
?>