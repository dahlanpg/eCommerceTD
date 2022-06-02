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
            if(!isset($_GET["email"]))
                throw new Exception("Digite um email válido");
            $email = filtraEntrada($_GET["email"]);
            if(!strstr($email, "@") || !strstr($email, "."))
				throw new Exception("Email inválido<br>");
            $idClient = $_SESSION["id"];
            $conn->begin_transaction();
            $sql = "update tdclient set email = ? where id = $idClient;";
            
            if(!$stmt = $conn->prepare($sql)){
                throw new Exception("Falha na operacao prepare: " . $conn->error);
            }
            if(!$stmt->bind_param("s", $email))
                throw new Exception("Falha na operacao bind_param: " . $stmt->error);

            if (! $stmt->execute())
                  throw new Exception("Falha na operacao execute: " . $stmt->error);
            
            $sql = "update tduser set login = ? where iduser = $idClient;";
            
            if(!$stmt = $conn->prepare($sql)){
                throw new Exception("Falha na operacao prepare: " . $conn->error);
            }
            if(!$stmt->bind_param("s", $email))
                throw new Exception("Falha na operacao bind_param: " . $stmt->error);
      
            if (! $stmt->execute())
                throw new Exception("Falha na operacao execute: " . $stmt->error);
            $_SESSION["email"] = $email;
            $conn->commit();
            echo "ok";
        }
    }catch(Exception $e){
        $e->getMessage();
        if(isset($conn))
			$conn->rollback();
    }finally{
        if(isset($conn))
            $conn->close();
    }

?>