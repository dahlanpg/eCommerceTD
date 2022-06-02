<?php
    session_start();
    require "connectionMysql.php";
    $pasta = ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "myAccount" . DIRECTORY_SEPARATOR . "avatar" . DIRECTORY_SEPARATOR;

    /* formatos de imagem permitidos */
    $permitidos = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");

    if (isset($_POST) && isset($_FILES['avatarImg']['name'])) {
        $nome_imagem    = $_FILES['avatarImg']['name'];
        $tamanho_imagem = $_FILES['avatarImg']['size'];

        /* pega a extensão do arquivo */
        $ext = strtolower(strrchr($nome_imagem, "."));

        /*  verifica se a extensão está entre as extensões permitidas */
        if (in_array($ext, $permitidos)) {
            /* converte o tamanho para KB */
            $tamanho = round($tamanho_imagem / 1024);

            if ($tamanho < 1024) { //se imagem for até 1MB envia
                $nome_atual = md5(uniqid(time())) . $ext; //nome que dará a imagem
                $tmp = $_FILES['avatarImg']['tmp_name']; //caminho temporário da imagem

                /* se enviar a foto, insere o nome da foto no banco de dados */
                if (move_uploaded_file($tmp, $pasta . $nome_atual)) {
                    $directory = "images" . DIRECTORY_SEPARATOR . "myAccount" . DIRECTORY_SEPARATOR . "avatar" . DIRECTORY_SEPARATOR . $nome_atual;
                    try{
                    $conn = connectionToMySQL();
                    $idClient = $_SESSION["id"];
                    $sql = "update tdclient set avatar = '$nome_atual' where id = $idClient;";
                    if(!$conn->query($sql))
                        throw new Exception("Erro no envio");
                    if(isset($_SESSION["avatar"])){ //deleta imagem antiga
                        $pathImg = ".." . DIRECTORY_SEPARATOR . "images" . 
                        DIRECTORY_SEPARATOR . "myAccount" . DIRECTORY_SEPARATOR . "avatar" . DIRECTORY_SEPARATOR
                        . $_SESSION["avatar"] ;
                        try{
                            if(!unlink($pathImg))
                                throw new Exception( "Falha ao remover imagem");
                        }catch(Exception $e){
                            
                        }
                    }
                    $_SESSION["avatar"] = $nome_atual;
                    $conn->close();
                    echo "<img src='$directory' id='avatarImage' class='avatar'>"; //imprime a foto na tela
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
    } else {
        if(isset($_SESSION["avatar"])){
            $avatar = $_SESSION["avatar"];
            echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/$avatar'>";
        }
        if ($_SESSION["gender"] == 'M')
            echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarM.jpg'>";
        else if ($_SESSION["gender"] == 'F')
            echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarF.jpg'>";
        else if ($_SESSION["gender"] == 'O')
            echo "<img id='avatarImage' class='avatar' src='images/myAccount/avatar/noAvatarO.png'>";
    }
?>