<?php
    session_start();
    require_once "connectionMysql.php";
    require_once "autentication.php";
    try{
        $conn = connectionToMySQL();
        if(!checkUserIsLoggedOrDie($conn)){
            session_destroy();
            header("Location: login.php?for=2");
        }else{
            if(!isset($_GET["name"]))
                throw new Exception("Digite um nome válido");
            $name     = filtraEntrada($_GET["name"]);
            $idClient = $_SESSION["id"];
            $sql = "update tdclient set name = ? where id = $idClient;";
            if(!$stmt = $conn->prepare($sql)){
                throw new Exception("Falha na operacao prepare: " . $conn->error);
            }
            if(!$stmt->bind_param("s", $name))
                throw new Exception("Falha na operacao bind_param: " . $stmt->error);

            if (! $stmt->execute())
                  throw new Exception("Falha na operacao execute: " . $stmt->error);
            $_SESSION["name"] = $name;
            echo "ok";
        }
    }catch(Exception $e){
        $e->getMessage();
    }finally{
        if(isset($stmt))
            $stmt->close();
        if(isset($conn))
            $conn->close();
    }

?>