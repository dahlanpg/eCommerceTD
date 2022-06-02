<?php
    session_start();
    $name = $_GET["name"];
    require "connectionMysql.php";
    $pasta = ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "sale" . DIRECTORY_SEPARATOR;
    // $name
    /* formatos de imagem permitidos */
    $permitidos = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
    
    if (isset($_POST) && isset($_FILES[$name]['name'])) {
        $nome_imagem    = $_FILES[$name]['name'];
        $tamanho_imagem = $_FILES[$name]['size'];
    
        /* pega a extensão do arquivo */
        $ext = strtolower(strrchr($nome_imagem, "."));
    
        /*  verifica se a extensão está entre as extensões permitidas */
        if (in_array($ext, $permitidos)) {
            /* converte o tamanho para KB */
            $tamanho = round($tamanho_imagem / 1024);
    
            if ($tamanho < 1024) { //se imagem for até 1MB envia
                $nome_atual = md5(uniqid(time())) . $ext; //nome que dará a imagem
                $tmp = $_FILES[$name]['tmp_name']; //caminho temporário da imagem
    
                /* se enviar a foto, insere o nome da foto no banco de dados */
                if (move_uploaded_file($tmp, $pasta . $nome_atual)) {
                    $directory = "images" . DIRECTORY_SEPARATOR . "sale" . DIRECTORY_SEPARATOR . $nome_atual;
                    try{
                    $conn = connectionToMySQL();
                    $indicator = substr($name, -1);
                    $sql = "select image" . $indicator . " as img from tdbannershome;";
                    $result = $conn->query($sql);
                    if(!$result){
                        echo "Falha ao deletar imagem";
                        die();
                    }
                    $row = $result->fetch_assoc();
                    $imagemBanner = $row["img"];
                    $dir = ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .
                     "sale" . DIRECTORY_SEPARATOR . $imagemBanner;
                     try{
                        if(!unlink($dir))
                            throw new Exception( "Falha ao remover imagem");
                    }catch(Exception $e){
                        
                    }
                    
                    $sql = "update tdbannershome set image" . $indicator ." = '$nome_atual' where 1=1;";
                    if(!$conn->query($sql))
                        echo "erro";
                    $conn->close();
                    echo "<img src='$directory' id='bannerImage' class='banner'>"; //imprime a foto na tela
                    }catch(Exception $e){
                        echo $e->getMessage();
                    }
                } else {
                    echo "Falha ao enviar";
                }
            } else {
                echo "A imagem deve ser de no máximo 1MB";
            }
        } else {
            echo "Somente são aceitos arquivos do tipo Imagem";
        }
    }
    
?>