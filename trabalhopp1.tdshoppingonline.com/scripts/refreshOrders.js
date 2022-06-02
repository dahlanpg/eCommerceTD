function refreshOrders(){
    var xmlhttp = new XMLHttpRequest();

    var method = 'GET';
    var url = "scripts/refreshOrders.php";
    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {
            document.getElementById('listOrdersTr').innerHTML = xmlhttp.responseText;
        }
        else {
             alert("Erro ao recuperar seus pedidos");
        }
    };

    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };

    xmlhttp.send();
 }