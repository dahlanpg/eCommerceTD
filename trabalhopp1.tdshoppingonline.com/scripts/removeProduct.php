<?php
    try{
    $idProduct = $_GET["idProduct"];
    require_once "connectionMysql.php";
    $conn = connectionToMySQL();
    $sql = "select image1, image2, category from tdproducts;";
    $result = $conn->query($sql);
    if(!$result){
        throw new Exception("O respectivo produto nao foi encontrado");
    }
    $row = $result->fetch_assoc();
    $image1   = $row["image1"];
    $image2   = $row["image2"];
    $category = $row["category"];
    $pathImg = "..".DIRECTORY_SEPARATOR."images" . 
    DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $category . DIRECTORY_SEPARATOR;

    $pathImg1 = $pathImg.$image1;
    $pathImg2 = $pathImg.$image2;

    
    $sql = "DELETE from tdproducts where idproduct = $idProduct;";
    if(!$conn->query($sql)){
        throw new Exception("Erro na operacao de remover");
    }
    echo "ok"; 
    if(isset($image1) || $image1 != ""){
         if(!unlink($pathImg1)){
            throw new Exception("Nao foi possivel limpar dados do produto");
         }
    }
                
    if(isset($image2) || $image2 != ""){
        if(!unlink($pathImg2)){
            throw new Exception("Nao foi possivel limpar dados do produto");
        }
    }
    }catch(Exception $e){
        echo $e->getMessage();
    }finally{
        if($conn != null)
             $conn->close();
    }
?>