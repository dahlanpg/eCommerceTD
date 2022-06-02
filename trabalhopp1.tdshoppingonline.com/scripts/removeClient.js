var currentId = 0;
var currentClient;

function removeClient() {
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/removeClient.php?idClient=" + currentId;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
        if(xmlhttp.responseText == "ok")
            $(currentClient).hide(500);
        else
            alert(xmlhttp.responseText);
    };
    
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };
    
    xmlhttp.send();
}

function recordId(idClient, clientRow){
    currentId = idClient;
    currentClient = clientRow.parentElement.parentElement;
}