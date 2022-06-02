<?php
    session_start();
    if(!isset($_SESSION["id"]))
        die();
    try{
      require_once "connectionMysql.php";
      $idProduct = $_GET["idProduct"];
      $idClient  = $_SESSION["id"];
      $conn = connectionToMySQL();
      $sql = "delete from tdfavorites 
              where iduser = $idClient and idproduct = $idProduct;";
      if(!$conn->query($sql))
            throw new Exception("Não foi possivel remover");

    echo "ok";
    }catch(Exception $e){
        echo $e->getMessage();
    }finally{
        if(isset($conn) && $conn != null)
            $conn->close();
    }
    
?>