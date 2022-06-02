function detailsWish(idOrder) {
    var xmlhttp = new XMLHttpRequest();
    var method = 'GET';
    var url = "scripts/detailsWish.php?idOrder=" + idOrder;

    xmlhttp.open(method, url, true);
    xmlhttp.onload = function () {
          document.getElementById("orderProduct").innerHTML = xmlhttp.responseText;
    };
    
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao processar a requisição");
    };
    
    xmlhttp.send();
}