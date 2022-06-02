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
            if(!isset($_GET["ddi"], $_GET["ddd"], $_GET["phone"]))
                throw new Exception("Campos inválidos");
            $ddi   = filtraEntrada($_GET["ddi"]);
            $ddd   = filtraEntrada($_GET["ddd"]);
            $phone = filtraEntrada($_GET["phone"]);

            if(!is_numeric($ddi) || strlen($ddi) != 2)
                throw new Exception("ddi inválido<br>");
            if(!is_numeric($ddd) || strlen($ddd) != 2)
                throw new Exception("ddd inválido<br>");
            if(!is_numeric($phone) || strlen($phone) != 9)
				throw new Exception("Número de telefone inválido<br>");
            $idClient = $_SESSION["id"];
            //$conn->begin_transaction();
            $sql = "update tdphone set ddi = ?, ddd = ?, phone = ? where idclient = $idClient;";
            
            if(!$stmt = $conn->prepare($sql)){
                throw new Exception("Falha na operacao prepare: " . $conn->error);
            }
            if(!$stmt->bind_param("iis", $ddi, $ddd, $phone))
                throw new Exception("Falha na operacao bind_param: " . $stmt->error);

            if (! $stmt->execute())
                  throw new Exception("Falha na operacao execute: " . $stmt->error);
            
            $_SESSION["ddi"]   = $ddi;
            $_SESSION["ddd"]   = $ddd;
            $_SESSION["phone"] = $phone;
            //$conn->commit();
            echo "ok";
        }
    }catch(Exception $e){
        $e->getMessage();
        // if(isset($conn))
		// 	$conn->rollback();
    }finally{
        if(isset($stmt))
            $stmt->close();
        if(isset($conn))
            $conn->close();
    }

?>