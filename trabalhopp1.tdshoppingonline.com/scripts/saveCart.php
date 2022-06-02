<?php
try{
    $idProduct = $_GET["idProduct"];
    $qtd       = $_GET["qtd"];
    $arrayIds  = [];
    $arrayQtds = [];
    if($idProduct == "" || !isset($_COOKIE["cart"])){
        throw new Exception( "erro");
    }else{
        $arrayIds = json_decode($_COOKIE["cart"]);
        $indexProduct = -1;
        for($i = 0; $i < sizeof($arrayIds); ++$i){
            if($arrayIds[$i] == $idProduct){
                $indexProduct = $i;
                break;
            }
        }
        if($indexProduct == -1){
            throw new Exception( "erro");
        }
        if(isset($_COOKIE["qtd"])){
            $arrayQtds = json_decode($_COOKIE["qtd"]);
            if(!is_array($arrayQtds))
                throw new Exception("Erro");
            $arrayQtds[$indexProduct] = $qtd;
        }else{
            $arrayQtds[$indexProduct] = $qtd;
        }

        $jsonQtd = json_encode($arrayQtds);
        $jsonIds = json_encode($arrayIds);
    }
    
    setcookie("cart", $jsonIds, time() + (86400 * 7), "/");
    setcookie("qtd", $jsonQtd, time() + (86400 * 7), "/");
    echo "ok";
}catch(Exception $e){
    setcookie("cart", "", time() - (86400 * 7), "/");
    setcookie("qtd", "", time() - (86400 * 7), "/");
    echo $e->getMessage();
}
?>