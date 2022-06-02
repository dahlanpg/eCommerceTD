function listClientsAdmin(){
    var xmlhttp = new XMLHttpRequest();

    var method = 'GET';
    var url = "scripts/listClientsAdmin.php";
    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {
            document.getElementById('listClientsTr').innerHTML = xmlhttp.responseText;
        }
        else {
            alert(xmlhttp.responseText);
             //alert("Erro ao recuperar pedidos");
        }
    };

    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };

    xmlhttp.send();
 }