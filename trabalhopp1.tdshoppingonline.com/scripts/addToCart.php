<?php
    $idProduct = $_GET["idProduct"];
    $arrayIds = [];
    $arrayQtds = [];
    if($idProduct != "" && !isset($_COOKIE["cart"])){
        $arrayIds[] = $idProduct;
    }else{
        $arrayIds = json_decode($_COOKIE["cart"]);
        if(!in_array($idProduct, $arrayIds))
             $arrayIds[] = $idProduct;
        else
            echo "erro";
    }
    $jsonProducts = json_encode($arrayIds);
    setcookie("cart", $jsonProducts, time() + (86400 * 7), "/");
?>