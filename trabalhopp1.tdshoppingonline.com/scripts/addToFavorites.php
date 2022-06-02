<?php
    session_start();
    try{
        if(!isset($_SESSION["id"]))
            die();
        require_once "connectionMysql.php";
        require_once "products.php";

        $idProduct = $_GET["idProduct"];
        $idClient  = $_SESSION["id"];
        $idClient = intval($idClient);

        $conn = connectionToMySQL();

        $sql = "select idproduct from tdfavorites where iduser = $idClient and idproduct = $idProduct;";
        
        $result = $conn->query($sql);
        if($result->num_rows > 0)
            throw new Exception("Esse produto já está entre os seus favoritos");
        $sql = "insert into tdfavorites(iduser, idproduct) values($idClient, $idProduct);";

        if(!$conn->query($sql))
            throw new Exception("Falha ao inserir produto nos favoritos");
        echo "ok";

    }catch(Exception $e){
        echo $e->getMessage();

    }finally{
        if($conn != null)
            $conn->close();
    }
?>