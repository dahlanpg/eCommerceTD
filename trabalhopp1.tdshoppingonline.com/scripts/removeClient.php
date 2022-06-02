<?php
    try{
    $idClient = $_GET["idClient"];
    require_once "connectionMysql.php";
    $conn = connectionToMySQL();

    $sql = "DELETE from tdclient where id = $idClient;";
    if(!$conn->query($sql)){
        throw new Exception("Erro na operacao de remover");
    }
    echo "ok"; 
    }catch(Exception $e){
        echo $e->getMessage();
    }finally{
        if($conn != null)
             $conn->close();
    }
?>