<?php

    $idProduct = $_GET["idProduct"];

    $idsCookie = json_decode($_COOKIE["cart"]);
    if(isset($_COOKIE["qtd"]))
        $qtdsCart  = json_decode($_COOKIE["qtd"]);
    else
        $qtdsCart = null;
    $newArray = [];
    $newArrayQtds = [];
    for($i = 0; $i < sizeof($idsCookie) ; ++$i){
        if($idsCookie[$i] != $idProduct){
            $newArray[] = $idsCookie[$i];
            if(is_array($qtdsCart))
                $newArrayQtds[] = $qtdsCart[$i];
        }
    }

    $jsonProducts = json_encode($newArray);
    if(is_array($qtdsCart)){
        $jsonQtd = json_encode($newArrayQtds);
        setcookie("qtd", $jsonQtd, time() + (86400) * 7, "/");
    }
    setcookie("cart", $jsonProducts, time() + (86400 * 7), "/");
?>