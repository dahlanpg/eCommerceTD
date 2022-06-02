<?php
    function uploadImagesProduct($nameInput, $folder){
        //$folder = ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "sale" . DIRECTORY_SEPARATOR;
        // $nameInput
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        
        if (isset($_POST) && isset($_FILES[$nameInput]['name'])) {
            $imageName    = $_FILES[$nameInput]['name'];
            $imageSize    = $_FILES[$nameInput]['size'];
        
            /* pega a extensão do arquivo */
            $ext = strtolower(strrchr($imageName, "."));
        
            /*  verifica se a extensão está entre as extensões permitidas */
            if (in_array($ext, $permitidos)) {
                /* converte o tamanho para KB */
                $size = round($imageSize / 1024);
        
                if ($size < 1024) { //se imagem for até 1MB envia
                    $currentName = md5(uniqid(time())) . $ext; //nome que dará a imagem
                    $tmp = $_FILES[$nameInput]['tmp_name']; //caminho temporário da imagem
        
                    /* se enviar a foto, insere o nome da foto no banco de dados */
                    if (move_uploaded_file($tmp, $folder . $currentName)) {
                        //$directory = "images" . DIRECTORY_SEPARATOR . "sale" . DIRECTORY_SEPARATOR . $currentName;
                        return $currentName;
                    } else {
                        echo "Falha ao enviar<br>";
                        return "erro";
                    }
                } else {
                    echo "A imagem deve ser de no máximo 1MB<br>";
                    return "erro";
                }
            } else {
                echo "Somente são aceitos arquivos do tipo Imagem<br>";
                return "erro";
            }
        }
    }
    
?>