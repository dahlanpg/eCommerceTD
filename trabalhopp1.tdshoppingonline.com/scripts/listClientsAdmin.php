<?php
    try{
        require_once "connectionMysql.php";
        require_once "client.php";

        $conn = connectionToMySQL();
        $clients = getClients($conn);

        for ($i = 0; $i < sizeof($clients); ++$i) {
            $client = $clients[$i];
            echo "<tr>
            <td>$client->id</td>
            <td>$client->name</td>
            <td><img onclick='redirect($client->id)' src='images/admin/packing-list.png' class='clientDetailsImg'></td>
            <td><img onclick='recordId($client->id, this)' src='images/admin/removeUser.png' class='clientRemoveImg' data-toggle='modal' data-target='#confirm'></td>
            </tr>";
        }

    }catch(Exception $e){
        echo $e->getMessage();
    }
