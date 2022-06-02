<?php
    try{
        session_start();
        require_once "connectionMysql.php";
        require_once "autentication.php";
        require_once "products.php";
        $conn = connectionToMySQL();
        if(!checkUserIsLoggedOrDie($conn))
            die();
        $conn->begin_transaction();

        if(!isset($_GET["methodPayment"]))
            throw new Exception("Método de pagamento nao especificado");

        $methodPayment = $_GET["methodPayment"];
        $arrayQtds = json_decode($_POST['data']);

        if(sizeof($arrayQtds) == 0)
            throw new Exception("Erro ao encaminhar dados para o servidor");
        
        $cart = json_decode($_COOKIE["cart"]);
        if(!isset($cart)){
            throw new Exception("Carrinho inválido");
        }
        for($i = 0; $i < sizeof($cart); ++$i){
            $sql = "update tdproducts";
        }
        $totalValue = 0;
        $finalValue = 0;
        $status = "Pedido em andamento";
        $idClient = $_SESSION["id"];
        if(!is_array($cart))
            throw new Exception("Nao há itens no carrinho");

        $sql = "INSERT into tdorders(totalvalue,status,iduser,paymentMethod)
         values($totalValue, '$status', $idClient,'$methodPayment');";
        if(!$conn->query($sql)){
            throw new Exception("Erro ao efetuar pedido");
        }
        $sql = "SELECT LAST_INSERT_ID();";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $idOrder = $row["LAST_INSERT_ID()"];
        $idOrder = intval($idOrder);

        for($i = 0; $i < sizeof($cart); ++$i){
            if(isset($cart[$i], $arrayQtds[$i])){
                $product    = getProductById($conn, $cart[$i]);
                $quantity   = intval($arrayQtds[$i]);
                $finalValue = floatval($product->price) * $quantity;
                $totalValue += $finalValue;
                $prodId     = intval($product->id);
                $prodPrice  = floatval($product->price);
                $sql        = "select sold,name, quantity from tdproducts where idproduct = $prodId;";
                $result     = $conn->query($sql);
                if(!$result)
                    throw new Exception("Erro ao resgatar dados dos produtos");
                $row      = $result->fetch_assoc();
                $sold     = $row["sold"]; //pega numero de vendidos
                $stock    = $row["quantity"];
                $nameP    = $row["name"];
                $stock    = intval($stock);
                $sold     = intval($sold);
                $stock   -= $arrayQtds[$i];
                if(!is_numeric($stock) || $stock < 0){
                    setcookie("cart", "", time() - (86400 * 7), "/");
                    setcookie("qtd", "", time() - (86400 * 7), "/");
                    throw new Exception("Não há estoque suficiente para o produto $nameP");
                }
                $sql = "INSERT into tdorders_products(idorders, idproduct, 
                unitValue, finalValue, quantity) values($idOrder, $prodId,
                $prodPrice, $totalValue, $quantity);";
                if(!$conn->query($sql))
                    throw new Exception("Erro ao criar pedido");
                
                ++$sold; //vendeu +1
                $sql = "update tdproducts set sold = $sold, quantity = $stock where idproduct = $prodId;";
                if(!$conn->query($sql))
                    throw new Exception("Erro ao atualizar dados do produto");
            }
        }
        $sql = "update tdorders set totalValue = $totalValue where id_order = $idOrder;";
        if(!$conn->query($sql)){
            throw new Exception("Não foi possivel realizar o pedido");
        }
        $conn->commit();
        setcookie("cart", "", time() - (86400 * 7), "/");
        setcookie("qtd", "", time() - (86400 * 7), "/");
        echo "OK";
    }catch(Exception $e){
        $conn->rollback();
        echo $e->getMessage();
    }finally{
        if(isset($conn))
            $conn->close();
    }
    
?>