<?php
    try
        {   
            require_once "connectionMysql.php";
            require_once "uploadImagesProduct.php";
            $offertitle = $name = $manufacturer = $category = $price = $quantity = $description = $attributes = "";

            if (!isset($_POST["offerTitle"]))
                throw new Exception("O titulo da oferta deve ser fornecido");
            if (!isset($_POST["name"]))
                throw new Exception("O name deve ser fornecido");
            if (!isset($_POST["category"]))
                throw new Exception("A categoria deve ser fornecida");
            if (!isset($_POST["quantity"]))
                throw new Exception("O estoque deve ser fornecido");
            if (!isset($_POST["description"]))
                throw new Exception("A descricao do produto deve ser fornecida");
            if(!isset($_POST["manufacturer"]))
                throw new Exception("O fabricante do produto deve ser fornecido");

            $offertitle     = filtraEntrada($_POST["offerTitle"]);
            $name           = filtraEntrada($_POST["name"]);
            $category       = filtraEntrada($_POST["category"]);
            $manufacturer   = filtraEntrada($_POST["manufacturer"]);
            $price          = filtraEntrada($_POST["price"]);
            $quantity       = filtraEntrada($_POST["quantity"]);
            $description    = filtraEntrada($_POST["description"]);
            $attributes     = $_POST["attibutesText"];
            $sold = 0;

            if ($offertitle == "")
                throw new Exception("O titulo da oferta deve ser fornecido");
            if ($name == "")
                throw new Exception("O nome do produto deve ser fornecido");
            if ($category == "")
                throw new Exception("A categoria do produto deve ser fornecido");
            if ($manufacturer == "")
                throw new Exception("O fabricante do produto deve ser fornecido");
            if ($price == "")
                throw new Exception("O preço do produto deve ser fornecido");
            if ($quantity == "")
                throw new Exception("A quantidade do produto deve ser fornecida");

            $conn = connectionToMySQL();
            $nameImage1 = $nameImage2 = "";
            $folder = ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $category . DIRECTORY_SEPARATOR;
            if(isset($_FILES["imgRegister1"]['name']) && $_FILES["imgRegister1"]['name'] != ""){
                $nameImage1 = uploadImagesProduct("imgRegister1", $folder);
            }
            if(isset($_FILES["imgRegister2"]['name']) && $_FILES["imgRegister2"]['name'] != ""){
                if($nameImage1 != "")
                    $nameImage2 = uploadImagesProduct("imgRegister2", $folder);
                else
                    $nameImage1 = uploadImagesProduct("imgRegister2", $folder);
            }

            if($nameImage1 == "" && $nameImage2 == "")
                throw new Exception("Pelo menos uma imagem deve ser fornecida");

            if($nameImage1 == "erro" || $nameImage2 == "erro"){
                throw new Exception("Erro ao fazer upload das imagens");
            }

            if($nameImage2 == "")
                $nameImage2 = null;

            $sql = "INSERT INTO tdproducts (offertitle,name,category,description, 
            manufacturer, price, quantity,attributes, sold, image1, image2)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            
            if (!$stmt = $conn->prepare($sql))
                throw new Exception("Falha na operacao prepare: " . $conn->error);
            if (!$stmt->bind_param("sssssdisiss", $offertitle, $name, $category, $description
            , $manufacturer, $price, $quantity, $attributes, $sold, $nameImage1, $nameImage2))
                throw new Exception("Falha na operacao bind_param: " . $stmt->error);
            if (!$stmt->execute())
                throw new Exception("Falha na operacao execute: " . $stmt->error);   

            if($stmt != null)
            $stmt->close();
            
            if($conn != null)
            $conn->close();

            
            //backup dos produtos em txt
            $nameTxt = 'sqlProducts.txt';
            $text = "INSERT INTO tdproducts (offertitle,name,category,description, 
            manufacturer, price, quantity,attributes, sold, image1, image2)
            VALUES ('$offertitle','$name', '$category', '$description', '$manufacturer', $price, $quantity, '$attributes', $sold, '$nameImage1', '$nameImage2');\r\n";
            $file = fopen($nameTxt, 'a');
            fwrite($file, $text);
            fclose($file);

            echo "OK Dados cadastrados: $offertitle, $name, $category";
        }
        catch (Exception $e){
            http_response_code(400);

            $msgErro = $e->getMessage();
            echo $msgErro;
        }

    ?>